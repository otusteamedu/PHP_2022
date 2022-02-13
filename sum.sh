#!/bin/bash

number1=$1
number2=$2

regular='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $number1 =~ $regular ]] || ! [[ $number2 =~ $regular ]]; then
  echo "Error: enter the numbers." >&2
  exit 1
fi

echo 'printf "%.2f \n" $(( ' $number1 + $number2 ' ))' | zsh