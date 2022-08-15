#!/usr/bin/env bash

if [ "$#" != 2 ]; then
  echo 'Give me two numbers'
  exit 1
fi

echo "$1 + $2" | bc