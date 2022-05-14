#!/bin/bash
regex='^[+-]?[0-9]+([.|,][0-9]+)?$'
if [[ $1 =~ $regex ]]; then
c=$1
else
echo "$1 - не валидно"
exit 1
fi
if [[ $2 =~ $regex ]]; then
x=$2
else
echo "$2 - не валидно"
exit 1
fi
awk "BEGIN {print $c + $x}"