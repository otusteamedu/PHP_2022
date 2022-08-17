#!/usr/bin/env bash

if [[ "$1" == "-h" ]] || [[ "$1" == "--help" ]]; then
  echo "Скрипт для получения суммы двух чисел."
  exit 1
fi

if [[ "$#" != 2 ]]; then
  echo "Необходимо указать 2 параметра."
  exit 1
fi

regex="^[-]?[0-9]*[.]?[0-9]+$"
if ! [[ "$1" =~ $regex ]] || ! [[ "$2" =~ $regex ]]; then
  echo "Перепроверьте вводимые данные, допускается разделение дробной части через точку."
  exit 1
fi

sum=$(awk "BEGIN {print $1 + $2}")
echo $sum
exit 1
