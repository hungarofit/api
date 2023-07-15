#!/usr/bin/env bash

HOST=${HOST:-http://localhost:8080}
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

start_time=$(date +%s%N)
curl -L -X POST -H "Content-Type: application/json" -H "Origin: bogus" -d @$SCRIPT_DIR/evaluate.json $HOST/evaluate
end_time=$(date +%s%N)
duration=$((($end_time - $start_time) / 1000000))
echo $duration ms
