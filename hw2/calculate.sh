#!/bin/bash

regex='^-?[0-9]+[.,]?[0-9]*$'
for var in $@; do
    if ! [[ $var =~ $regex ]] ; then
        echo "Error: $var нечисловое значение"
		exit 1
    fi
done

sum=`echo $1 $2 | awk '{print $1 + $2}'`
echo "Сумма двух чисел: $sum"