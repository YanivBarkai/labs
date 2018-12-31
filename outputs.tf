output "dc_public_ip" {
  value = "${aws_instance.ad.public_ip}"
}

output "windows_client_public_ip" {
  value = "${aws_instance.client.public_ip}"
}

output "web_ip" {
  value = "${aws_instance.web.public_ip}"
}

output "mysql_ip" {
  value = "${aws_instance.mysql.public_ip}"
}