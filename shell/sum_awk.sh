#!/usr/bin/bash

regex='^[-+]?[0-9]+\.?[0-9]*$'

if ! [[ $1 =~ $regex ]]; then
  echo "$1 - first param is not a number"
  exit 1
fi

if ! [[ $2 =~ $regex ]]; then
  echo "$2 - second param is not a number"
  exit 1
fi

sum="$(awk "BEGIN {print ($1+$2)}")"
echo "$1+$2=$sum"