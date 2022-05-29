#!/bin/bash

if [ $# -eq 0 ]; then
  echo "Введите аргументы"
  exit
fi

if [ -z "$2" ]; then
  echo "Нет второго аргумента"
  exit
fi

if [[ $(echo "$1" | awk '/^-?[0-9]*[.,]?[0-9]+$/{print $0}' | wc -l) -eq '0' ]] ; then
  echo "Аргументы должны быть числами";
  exit;
fi

if [[ $(echo $2 | awk '/^-?[0-9]*[.,]?[0-9]+$/{print $0}' | wc -l) -eq '0' ]] ; then
  echo "Аргументы должны быть числами";
  exit;
fi

sum=$(echo "$1 $2" | awk '{print $1 + $2}')

echo $sum
