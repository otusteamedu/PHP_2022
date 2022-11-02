#!/usr/bin/env bash

# если awk не установлен, отдаем ошибку
if ! command -v awk &> /dev/null
then
    echo "Please, install 'awk' package before using this script."
    exit
fi

pattern='^[\-]?([0-9]*[\.])?[0-9]+$'

if ! [[ $1 =~ $pattern ]]
then
    echo "Param 1 is not a number"
    exit
fi

if ! [[ $2 =~ $pattern ]]
then
    echo "Param 2 is not a number"
    exit
fi


sum=$(echo $1 $2 | awk '{print $1+$2}')
echo "Sum is $sum"
