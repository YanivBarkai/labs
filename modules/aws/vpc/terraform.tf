### Establish Provider and Access ###


### VPC Creation ###
resource "aws_vpc" "main" {
  cidr_block = "10.100.101.0/24"
  enable_dns_hostnames = "true"
  tags {
    Name = "${var.environment}"
  }
}


### Create Subnet for all of our resources ###
resource "aws_subnet" "main" {
  vpc_id     = "${aws_vpc.main.id}"
  cidr_block = "10.100.101.0/24"
  map_public_ip_on_launch = true
  tags {
    Name = "${var.environment}"
  }
}


### IGW for external calls ###
resource "aws_internet_gateway" "main" {
  vpc_id = "${aws_vpc.main.id}"
  tags {
    Name = "${var.environment}"
  }
}


### Route Table ###
resource "aws_route_table" "main" {
  vpc_id = "${aws_vpc.main.id}"
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = "${aws_internet_gateway.main.id}"
  }
}


### Main Route Table ###
resource "aws_main_route_table_association" "main" {
  vpc_id = "${aws_vpc.main.id}"
  route_table_id = "${aws_route_table.main.id}"
}
