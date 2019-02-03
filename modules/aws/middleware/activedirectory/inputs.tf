variable "environment" {
  description = "the name of your environment, e.g. \"prod-west\""
}

variable "windows2012r2_base_ami" {
  description = "Default AMI"
}

variable "key_name" {
  description = "ssh key for login"
}

variable "instance_type" {
  description = "instance type for ec2 instance"
  default     = "t3.medium"
}

variable "admin_password" {
  description = "Windows Administrator password to login as."
	default = "Aa123456!@#$"
}

variable "sp_admin" {
	default = "Aa123456!@#$"
}