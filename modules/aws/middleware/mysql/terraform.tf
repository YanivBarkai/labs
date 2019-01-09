data "terraform_remote_state" "main" {
  backend = "s3"
  config {
    bucket     = "triplec-labs-terraform-state"
    key        = "${var.environment}/vpc/terraform.tfstate"
    region     = "eu-central-1"
  }
}
resource "aws_instance" "main" {
  ami              = "${var.linux_base_ami}"
  instance_type    = "${var.instance_type}"
  key_name         = "${var.key_name}"
  subnet_id        = "${data.terraform_remote_state.main.aws_subnet_main_id}"
  # private_ip       = "10.100.101.53"
  vpc_security_group_ids = [
    "${aws_security_group.main.id}"
  ]
  tags  = {
    Name        = "MYSQL"
    Environment = "${var.environment}"
  }
  
# Boot takes time
  provisioner "local-exec" {
    command     = "sleep 140"
  }
  provisioner "local-exec" {
    command     = "ANSIBLE_HOST_KEY_CHECKING=False ansible-playbook -i '${aws_instance.main.public_ip},' -u ubuntu main.yml"
  }
}

resource "aws_security_group" "main" {
  name        = "${upper(var.environment)}-MYSQL-SG"
  vpc_id      = "${data.terraform_remote_state.main.aws_vpc_id}"
  tags        = {
    Environment = "${var.environment}"
    Name        = "MYSQL"
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