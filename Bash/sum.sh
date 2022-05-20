#!/bin/bash
echo $1 $2
re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]]; then
   echo "error: $1 -not a number"; exit 1
fi
if ! [[ $2 =~ $re ]]; then
   echo "error: $2 -not a number"; exit 1
fi

echo "Result: $(awk "BEGIN {print ($1+$2)}")"