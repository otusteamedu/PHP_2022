#!/bin/bash

#not number check
pattern="^[+-]?[0-9]+([.][0-9]+)?$"
if ! [[ $1 =~ $pattern ]];then
  echo "Error:The first argument is not a number"
  exit
elif ! [[ $2 =~ $pattern ]];then
  echo "Error:The second argument is not a number"
  exit
fi

#not bc package check
if command -v bc &> /dev/null
then
    echo "Result is `echo "$1+$2" | bc`"
else
    echo "Result is `awk "BEGIN {print $1+$2}"`"
fi




