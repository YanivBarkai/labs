data "terraform_remote_state" "main" {
  backend = "s3"
  config {
    bucket     = "triplec-labs-terraform-state"
    key        = "${var.environment}/vpc/terraform.tfstate"
    region     = "eu-central-1"
  }
}
resource "aws_vpc_dhcp_options_association" "dns_resolver" {
  vpc_id          = "${data.terraform_remote_state.main.aws_vpc_id}"
  dhcp_options_id = "${aws_vpc_dhcp_options.dns_resolver.id}"
}


### Set DNS resolvers so we can join a Domain Controller ###
resource "aws_vpc_dhcp_options" "dns_resolver" {
  domain_name_servers = [
    "8.8.8.8",
    "8.8.4.4",
    "${aws_instance.main.private_ip}"
  ]
  tags {
    Name = "${var.environment}"
  }
}


resource "aws_security_group" "main" {
  name        = "${upper(var.environment)}-ACTIVE-DIRECTORY"
  vpc_id      = "${data.terraform_remote_state.main.aws_vpc_id}"
  tags        = {
    Name        = "ACTIVE-DIRECTORY"
    Environment = "${upper(var.environment)}"
  }
  ingress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
    self        = "true"
  }
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

data "template_file" "init" {
    template = <<EOF
    <script>
      winrm quickconfig -q & winrm set winrm/config/winrs @{MaxMemoryPerShellMB="300"} & winrm set winrm/config @{MaxTimeoutms="1800000"} & winrm set winrm/config/service @{AllowUnencrypted="true"} & winrm set winrm/config/service/auth @{Basic="true"} & winrm/config @{MaxEnvelopeSizekb="8000kb"}
    </script>
    <powershell>
     netsh advfirewall firewall add rule name="WinRM in" protocol=TCP dir=in profile=any localport=5985 remoteip=any localip=any action=allow
     $admin = [ADSI]("WinNT://./administrator, user")
     $admin.SetPassword("${var.admin_password}")
    </powershell>
EOF
    vars {
      admin_password = "${var.admin_password}"
    }
}


### INLINE - W2012R2 - AD Server ###
resource "aws_instance" "main" {
  ami              = "${var.windows2012r2_base_ami}"
  instance_type    = "${var.instance_type}"
  key_name         = "${var.key_name}"
  user_data        = "${data.template_file.init.rendered}"
  subnet_id        = "${data.terraform_remote_state.main.aws_subnet_main_id}"
  private_ip       = "10.100.101.50"
  vpc_security_group_ids = [
    "${aws_security_group.main.id}"
  ]
  tags  = {
    Name        = "ACTIVE-DIRECTORY"
    Environment = "${upper(var.environment)}"
  }

  ### Allow AWS infrastructure metadata to propagate ###
  provisioner "local-exec" {
    command = "sleep 60"
  }

  ### Copy Scripts to EC2 instance ###
  provisioner "file" {
    source      = "${path.module}/scripts/"
    destination = "C:\\scripts"
    connection   = {
     type        = "winrm"
     user        = "Administrator"
     password    = "${var.admin_password}"
     agent       = "false"
    }
  }

  ### Set Execution Policy to Remote-Signed, Configure Active Directory ###
  provisioner "remote-exec" {
    connection = {
     type        = "winrm"
     user        = "Administrator"
     password    = "${var.admin_password}"
     agent       = "false"
    }
    inline = [
      "powershell.exe Set-ExecutionPolicy RemoteSigned -force",
      "powershell.exe -version 4 -ExecutionPolicy Bypass -File C:\\scripts\\bootstrap.ps1"
    ]
  }
}
