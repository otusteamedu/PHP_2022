#!/usr/bin/env bash
sum=0
reg='^[+-]?[0-9]+([.][0-9]+)?$'
if [[ $1 =~ $reg && $2 =~ $reg ]]; then
    sum=$(echo $1+$2 | bc)
    echo $sum
else
    echo 'Введите число'
fi