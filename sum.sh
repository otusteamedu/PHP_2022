#!/bin/bash

firstNumber=$1
secondNumber=$2
numberPattern='^[+-]?[0-9]+([.][0-9]+)?$'

if [ -n "$firstNumber" ] && [ -n "$secondNumber" ]; then
  if ! [[ $firstNumber =~ $numberPattern ]] || ! [[ $secondNumber =~ $numberPattern ]] ; then
    echo "Please use the numbers only in parameters"
  else
    echo "Sum of $firstNumber and $secondNumber is: $(awk "BEGIN {print $firstNumber+$secondNumber; exit}")"
  fi
else
  echo "Required parameters not found. Please add 2 numbers as parameters"
fi
