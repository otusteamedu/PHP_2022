#!/bin/bash

# Проверяем, установлен ли bc
if ! command -v bc &> /dev/null
then
    echo "error: bc not installed"
    exit 1
fi

# Проверяем количество аргументов
if [ "$#" -ne 2 ]; then
    echo "error: only 2 arguments is allowed!"
	exit 1
fi

#Проверям, что переданы именно числа
re='^[+-]?[0-9]+([.][0-9]+)?$'
for var in "$1" "$2"
do
if ! [[ ${var} =~ $re ]] ; then
   echo "error: ${var} not a number" >&2; exit 1
fi
done

#sum=$( expr $1 + $2 )
#let sum=$1+$2
sum=$(bc<<<"$1+$2")
echo "Summ: $sum"