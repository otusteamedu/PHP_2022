#!/bin/bash

regex='^([0-9\.\-]+)$';

badRegexp='^[0-9]+\,[0-9]+$';

if [[ $1 =~ $badRegexp ]] || [[ $2 =~ $badRegexp ]]; then
  echo "Ошибка ввода: Дробный числа записываются через точку";
  exit 1;
fi


if ! [[ $1 =~ $regex ]]; then
  echo "Первое значение не число";
  exit 1;
fi

if ! [[ $2 =~ $regex ]]; then
  echo "Второе значение не число";
  exit 1;
fi

 echo "Cумма чисел $1 + $2, равна:"
 awk "BEGIN{ print $1 + $2}";
