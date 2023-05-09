#!/bin/bash
if [[ $# -lt 2 ]] ; then
    echo "Должны быть переданы как минимум два параметра"
    exit 1;
fi
is_number='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $is_number ]] ; then
    echo "Параметр 1 ($1) должен быть числом";
    exit 1;
fi
if ! [[ $2 =~ $is_number ]] ; then
    echo "Параметр 2 ($2) должен быть числом";
    exit 1;
fi
awk -vx=$1 -vy=$2 'BEGIN { print strtonum(x)+strtonum(y) };'
