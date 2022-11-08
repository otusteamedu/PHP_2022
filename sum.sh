#!/bin/bash

installed=`dpkg -s bc | grep "Status"`

if [ -z "$installed" ]
then
  exit
fi

numRegex='^(-)?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $numRegex ]] || ! [[ $2 =~ $numRegex ]]
then
  echo "All arguments must be a number"
  exit
fi

sum=$(bc <<< "$1+$2")

echo "$1 + $2 = $sum"