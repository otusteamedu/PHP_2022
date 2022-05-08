#!/bin/bash

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

# Считаем без bc, чисто с помощью awk
sum=`echo "$1 $2" | awk '{print $1 + $2}'` 
echo "Summ: $sum"