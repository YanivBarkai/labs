variable "environment" {
  description = "the name of your environment, e.g. \"prod-west\""
}

variable "linux_base_ami" {
  description = "Default AMI"
}

variable "key_name" {
  description = "ssh key for login"
}

variable "instance_type" {
  description = "instance type for ec2 instance"
  default     = "t2.large"
}