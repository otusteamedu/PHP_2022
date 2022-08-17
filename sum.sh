#!/usr/bin/env bash

if [ "$#" != 2 ]; then
  echo 'Give me two numbers'
  exit 1
fi

for arg in "$@"
do
  if [[ "$arg" != $(echo -e "$arg" | grep -o '[0-9.-]\+') ]]; then
    echo "$arg is not a valid number"
    exit 1
  fi
done

awk "BEGIN {print $1 + $2}"