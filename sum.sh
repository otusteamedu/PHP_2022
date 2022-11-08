#!/bin/bash

a=$1
b=$2
CHECK_INPUT=$(echo `echo $a$b | grep '\-?\d+(\.\d{0,})?' | wc -l`)
if [ $CHECK_INPUT -gt 0 ]; then
    echo "Вы ввели некорректное число"
    exit 1
fi
echo $(bc <<< $a+$b)