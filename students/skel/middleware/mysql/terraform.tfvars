
terragrunt = {
  include {
    path = "${find_in_parent_folders()}"
  }
  dependencies {
    paths = ["../../vpc"]
  }
  terraform {
    source = "../../../..//modules/aws/middleware/mysql"
    extra_arguments "custom_vars" {
      commands = [
        "apply",
        "plan",
        "import",
        "push",
        "refresh",
        "destroy"
      ]

      required_var_files = [
        "${get_tfvars_dir()}/../../terraform.tfvars"
      ]
    }
  }
}