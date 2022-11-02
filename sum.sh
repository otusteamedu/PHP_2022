#!/usr/bin/env bash

# если cp не установлен, отдаем ошибку
if ! command -v bc &> /dev/null
then
    echo "Please, install 'cp' package before using this script."
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


sum=$(echo $1 + $2 | bc)
echo "Sum is $sum"
