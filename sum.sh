#!/bin/bash
if [ "$#" -ne "2" ]; then
    echo "Нужно вводить только два аргумента!"
    exit
fi
for param in "$@"
    do 
        if (echo "$param" | grep -E -q "^-?[0-9]+$"); then
            continue
        else
            echo "Параметр ( $param ) не являтся числом!"
            exit;
        fi
    done

total=$[ $1 + $2 ]
echo Сумма: $total