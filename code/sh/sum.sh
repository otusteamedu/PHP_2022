#!/bin/bash

numberPattern="^([-]?[0-9]+[\.\]?[0-9]+)$"

if [[ ! $(dpkg -s bc | grep 'Status: install ok') ]]; then
  echo 'Пакет bc не установлен!'
  exit 1
fi

if [ "$#" != 2 ]; then
  echo 'Некорректное количество параметров! Должно быть два числовых параметра!'
  exit 2
fi

if [[ ! $(echo $1 | grep -E $numberPattern) ]]; then
  echo 'Первый параметр не является корректным числом!'
  exit 3
fi

if [[ ! $(echo $2 | grep -E $numberPattern) ]]; then
  echo 'Второй параметр не является корректным числом!'
  exit 4
fi

sum=$(bc<<<"$1+$2")
echo 'Сумма:' $sum