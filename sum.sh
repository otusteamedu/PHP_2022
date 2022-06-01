#!/bin/bash

function numberValidator {
  if [[ $(echo "$1" | awk '/^-?[0-9]*[.,]?[0-9]+$/{print $0}' | wc -l) -eq '0' ]] ; then
    echo "Аргумент $1 должен быть числом"
    exit
  fi
}

if [ $# -eq 0 ]; then
  echo "Введите аргументы"
  exit
fi

if [ -z "$2" ]; then
  echo "Нет второго аргумента"
  exit
fi

numberValidator "$1"

numberValidator "$2"

sum=$(echo "$1 $2" | awk '{print $1 + $2}')

echo $sum
