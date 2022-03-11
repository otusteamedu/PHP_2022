#!/bin/bash
# Otus PHP course 1.2. Linux
# Написать консольное приложение (bash-скрипт), который принимает два числа и выводит их сумму в стандартный вывод. 


# check that required arguments are set
if [ -z "$1" ] ; then
   echo "Error: missing argument #1" >&2; exit 1
fi

if [ -z "$2" ] ; then
   echo "Error: missing argument #2" >&2; exit 1
fi

# assign values
X=$1
Y=$2

# check that numbers are passed
#re='^[\.-0-9]+$'
re='^-?[0-9]+[.,]?[0-9]*$'

if ! [[ $X =~ $re ]] ; then
   echo "Error: Not a number: $X" >&2; exit 1
fi

if ! [[ $Y =~ $re ]] ; then
   echo "Error: Not a number: $Y" >&2; exit 1
fi

awk "BEGIN{ print $X + $Y }"
