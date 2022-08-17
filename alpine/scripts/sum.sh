#!/usr/bin/env bash

if [ $# -eq 0 ]; then
  echo "Отсутствуют входящие параметры."
  exit 1
fi

if [ $# -gt 2 ]; then
  echo "Количество передаваемых параметров больше двух."
  exit 1
fi

for val in "$@"
do
  if ! [[ "$val" =~ ^[-]?[0-9]+([.][0-9]+)?$ ]]; then
    echo "$val - не является числом"
    exit 2
  fi
done

bc -v &> /dev/null

if [ $? -ne 0 ]; then
  echo "Для работы скрипта необходимо установить bc (basic calculator)"
  exit 3
fi

echo "$1 + $2" | bc
exit 0
