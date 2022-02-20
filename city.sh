#!/bin/bash

if ! [ -f data.txt ]; then
  echo "Ошибка! Файл с данными не существует"
  exit 1;
elif ! [ -s data.txt ]; then
    echo "Ошибка! Файл с данными пустой"
    exit 1
fi

awk '{if (FNR > 1) print $3}' data.txt | sort | uniq -c | sort -r |  head -n 3 |
awk 'BEGIN {print "Город | Кол-во повторений"} {print $2 " | " $1}'