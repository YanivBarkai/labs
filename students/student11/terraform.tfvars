terragrunt = {
  remote_state {
    backend = "s3"
    config {
      bucket     = "triplec-labs-terraform-state"
      key        = "student11/${path_relative_to_include()}/terraform.tfstate"
      region     = "eu-central-1"
      encrypt    = true
      lock_table = "student11-triplec-labs-terraform-lock"
    }
  }
}

environment 	         = "student11"
region                 = "eu-central-1"
key_name               = "TEMP"
linux_base_ami         = "ami-03d58d844fbb322af"
windows2012r2_base_ami = "ami-0f64d23e3531601de"