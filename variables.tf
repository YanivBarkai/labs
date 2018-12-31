variable "aws_region" {
  description = "The region for deployment"
  default = "eu-central-1"
}

variable "key_name" {
  description = "Name of the SSH keypair to use in AWS."
  default = {
    "eu-central-1"  = "TEMP"
  }
}


# Windows Server 2012 R2 Base AMI
variable "aws_w2012r2_std_amis" {
  default = {
    eu-central-1 = "ami-0f64d23e3531601de"
  }
}

variable "web_image" {
  default = {
    eu-central-1 = "ami-03d58d844fbb322af"
  }
}

variable "aws_app_instance_type" {
  default = "t2.large"
}

variable "aws_subnet_id" {
  default = {
    "us-east-1" = "subnet-xxxxxxxx"
    "us-west-2" = "subnet-xxxxxxxx"
  }
}

variable "aws_security_group" {
  default = {
    "us-east-1" = "sg-xxxxxxxx"
    "us-west-2" = "sg-xxxxxxxx"
  }
}

variable "stack_name" {
	default = "AD_TEMP"
}

variable "db_node_name" {
	default = "WindowsClient"
}

variable "ad_node_name" {
	default = "DOMAIM_CONTROLLER"
}

##### Script Related Resources #####


## Set Initial Windows Administrator Password ##
variable "admin_password" {
  description = "Windows Administrator password to login as."
	default = "Summer01!"
}

variable "sp_admin" {
	default = "Summer01!"
}
