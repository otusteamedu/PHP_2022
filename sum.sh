#!/bin/bash

regex='^[-+]?[0-9]+\.?[0-9]*$'

if ! [[ $1 =~ $regex ]]; then
  echo "Error. $1 - wrong number format"
  exit 1
fi

if ! [[ $2 =~ $regex ]]; then
  echo "Error. $2 - wrong number format"
  exit 1
fi

sum="$(awk "BEGIN {print ($1+$2)}")"
echo $sum