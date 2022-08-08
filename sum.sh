#!/bin/bash

if [ "$1" == "-help" ] || [ "$1" == "--help" ]; then
  echo "This script sums two numbers"
  exit 0
fi

if [ "$#" != 2 ]; then
  echo "This script requires two parameters"
  exit 1
fi

parametr1=$1
parametr2=$2

calc=$(($1 + $2))
echo $calc
exit 0