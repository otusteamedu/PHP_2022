#!/bin/bash

numRegex='^(-)?[0-9]+([,][0-9]+)?$'

if ! [[ $1 =~ $numRegex ]] || ! [[ $2 =~ $numRegex ]]
then
  echo "Arguments must be a number"
  exit
fi

echo "$1 $2"  | awk -F ' ' '{sum+=$1+$2} END {print $1 " + " $2 " = " sum}'