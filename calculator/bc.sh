#!/usr/bin/env bash

if [ "$1" == "-h" ] || [ "$1" == "--help" ]; then
  echo "Скрипт для получения суммы двух чисел."
fi

if [ "$#" != 2 ]; then
  echo "Необходимо передать два числа"
  exit 1
fi

regex="^[-]?[0-9]*[.,]?[0-9]+$"
if ! [[ "$1" =~ $regex ]] || ! [[ "$2" =~ $regex ]]; then
  echo "Переданы некорректные данные: допускаются целые числа и числа с плавающей точкой"
  exit 1
fi

PKG_EXISTS=$(dpkg-query -W --showformat='${Status}\n' bc | grep "install ok installed")

if [ "install ok installed" = "$PKG_EXISTS" ]; then
  sum=$(echo "$1 + $2" | bc)
else
  sum=$(awk "BEGIN {print $1 + $2}")
fi

echo "$sum"
exit 0
