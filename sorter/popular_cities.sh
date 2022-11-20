#!/usr/bin/env bash
# Выводи 3 наиболее популярных города из файла cities.txt

FILE_NAME="sorter/cities.txt"

if [[ "$1" ]]; then
  if [[ -f "$1" ]]; then
    FILE_NAME="$1"
  else
    echo "File $1 does not exist."
    exit
  fi
fi

echo "Проверяем файл $FILE_NAME"

awk -F' ' '{ print $3 }' $FILE_NAME | sort | uniq -c | sort -nr | head --lines 3