#!/bin/env bash

replace_dots() {
 echo $1 | awk '{gsub("\.",",",$1); print $1}'
}

regex='^[0-9,-]+$'
first_operand=`replace_dots $1`
second_operand=`replace_dots $2`

if ! [[ "$first_operand" =~ $regex ]]; then
  echo "error: first argument $first_operand is not a number" >&2
elif ! [[ "$second_operand" =~ $regex ]]; then
  echo "error: second argument $second_operand is not a number" >&2
else
  echo "$first_operand $second_operand" | awk '{print $1 + $2}'
fi