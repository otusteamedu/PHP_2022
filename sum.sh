#!/bin/bash

#not bc package check
if ! command -v bc &> /dev/null
then
    echo "Error:Not install bc package"
    exit
fi

#empty check
if [  -z "$1" ];then
  echo "Error:The first argument is empty"
  exit
elif [  -z "$2" ];then
  echo "Error:The second argument is empty"
  exit
fi

#not number check
pattern="^[+-]?[0-9]+([.][0-9]+)?$"
if ! [[ $1 =~ $pattern ]];then
  echo "Error:The first argument is not a number"
  exit
elif ! [[ $2 =~ $pattern ]];then
  echo "Error:The second argument is not a number"
  exit
fi


echo "Result is `echo "$1+$2" | bc`"