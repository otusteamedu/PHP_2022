#!/bin/bash

utilities="bc sed"
for utility in $utilities; do
  if ! command -v "$utility" &> /dev/null; then
      echo "Ошибка! Для работы с этим приложением вам необходимо установить утилиту $utility."
      echo "Для установки выполните следующие команды:"
      echo "apt-get update"
      echo "apt-get install $utility"
      exit
  fi
done

if [[ $# != 2 ]]; then
  echo "Ошибка! Передано неверное количество аргументов. Должно быть два аргумента."
  exit
fi

regexp="^-?[0-9]+(\.[0-9]+)?$"
result=0
for arg in "$@"; do
  if [[ $arg =~ $regexp ]]; then
    result=$(echo "$result+$arg" | bc | sed -e 's/^\./0./' -e 's/^-\./-0./')
  else
    echo "Ошибка! Аргумент \"$arg\" не является вещественным числом"
    exit
  fi
done

echo "$result"