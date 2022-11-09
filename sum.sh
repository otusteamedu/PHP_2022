#!/bin/bash

if ! command -v "awk" &>/dev/null; then
  echo "Ошибка! Для работы с этим приложением вам необходимо установить утилиту awk."
  echo "Для установки выполните следующие команды:"
  echo "apt-get update"
  echo "apt-get install awk"
  exit
fi

if [[ $# != 2 ]]; then
  echo "Ошибка! Передано неверное количество аргументов. Должно быть два аргумента."
  exit
fi

regexp="^-?[0-9]+(\.[0-9]+)?$"
result=0
for arg in "$@"; do
  if [[ $arg =~ $regexp ]]; then
    result=$(echo | awk "{print $result+$arg}")
  else
    echo "Ошибка! Аргумент \"$arg\" не является вещественным числом"
    exit
  fi
done

echo "$result"
