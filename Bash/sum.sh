#!/bin/bash
echo $1 $2
re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] && [[ $2 =~ $re ]]; then
   echo "error: Not a number" >&2; exit 1
fi
result=$(echo "$1+$2" | bc)
echo $result