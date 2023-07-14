#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

curl -sL -X POST -H "Content-Type: application/json" -H "Origin: bogus" -d @$SCRIPT_DIR/evaluate.json http://localhost:8080/evaluate
