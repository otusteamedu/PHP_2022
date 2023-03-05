#!/bin/bash
# This is script calculate the summa of two variables.

regex="[[:digit:]]"
if [[ ! $1 =~ $regex ]] || [[ ! $2 =~ $regex ]]
then
  echo "Enter digits for calculate the summ!"
  exit
fi

#sum=$(bc<<<"scale=3;$1+$2")
sum=$(awk -v a="$1" -v b="$2" 'BEGIN { printf "%s", a+b }')
echo $sum
