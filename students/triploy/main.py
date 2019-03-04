import argparse
from orchestrator import Orchestrator
TRIPLOY_VERSION = "0.0.1"

def set_parser():
    parser = argparse.ArgumentParser(description='TripleC demo environment deployment tool')
    # proto_group = parser.add_mutually_exclusive_group(required=True)
    parser.add_argument('-C', action='store_true', help='DO NOT deploy students state directories')
    parser.add_argument('-n', help='How many environments to deploy', default=2)
    parser.add_argument('terragrunt_options', nargs=argparse.REMAINDER)
    parser.add_argument('-ld', help="Terragrunt logs directory", default="./logs")
    args = parser.parse_args()
    return args

def main():
    args = set_parser()
    Orchestrator(args)
    


if __name__ == "__main__": # pragma: no cover
    main()