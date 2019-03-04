from triploy_logger import logger
import pathlib
import shutil
import sys, os, subprocess, time

class Orchestrator:
    def __init__(self, args):
        self.terragrunt_options = ' '.join(args.terragrunt_options)
        self.log_directory = args.ld
        self.triplec_student_number = args.n
        self.processes = {}
        if not args.C:
            self.deploy_students_directory_structure()
        if self.terragrunt_options != '':
            self.ensure_log_directory()
            self.vpc()
            self.poll_exit_code(self.processes)


    def deploy_students_directory_structure(self):
        logger.info("Deploying students state directories")
        cmd = "ansible-playbook playbook/main.yml --extra-vars students={}".format(self.triplec_student_number)
        ansible = {}
        ansible['deploy student directories'] = self.bash_command(cmd, os.devnull)
        self.poll_exit_code(ansible)

    def poll_exit_code(self, processes):
        for index in processes:
            process = processes[index]
            while process.poll() is None:
                time.sleep(2)
            return_code = process.returncode
            logger.info("Subprocess \'{0}\' finished with exit code {1}".format(index, return_code))

    def ensure_log_directory(self):
        logger.debug('Ensuring {} exist'.format(self.log_directory))
        pathlib.Path(self.log_directory).mkdir(parents=True, exist_ok=True)

    def _bash_command_log_handler(self, current_log_file):
        if current_log_file != "":
            log_handler_stdout = open(current_log_file, 'w')
            log_handler_stderr = log_handler_stdout
        else:
            log_handler_stdout = sys.stdout
            log_handler_stderr = sys.stderr
        return log_handler_stdout, log_handler_stderr

    def bash_command(self, cmd, current_log_file=""):
        log_handler_stdout, log_handler_stderr = self._bash_command_log_handler(current_log_file)
        logger.debug("Writing to {}".format(current_log_file))
        process = subprocess.Popen(['/bin/bash', '-c', cmd], stdout=log_handler_stdout, stderr=log_handler_stderr)
        return process
        # subprocess.Popen(['/bin/bash', '-c', cmd], stdout=sys.stdout, stderr=sys.stderr)
    
    def vpc(self):
        for index in range(1, self.triplec_student_number + 1):
            current_log_file = "{0}/student{1}".format(self.log_directory, index)
            cmd = "cd student-{0}/vpc && terragrunt {1}".format(index, self.terragrunt_options)
            logger.debug("Running \'{}\'".format(cmd))
            self.processes["student{}".format(index)] = self.bash_command(cmd , current_log_file)
