#!/usr/bin/env bash

if [ $# -eq 0 ]; then
  echo "Отсутствуют входящие параметры."
  exit 1
fi

while [ -n "$1" ]
do
  case "$1" in
    -h) echo -e "Использование: get-top-cities.sh [options] [FILE]\n\n-h    вывод справочной информации\n-f    получение 3 наиболее популярных городов среди пользователей системы из файла"
      exit 0;;
    -f)
      if [ -z "$2" ]; then
        echo "Файл не указан."
        exit 1
      fi
      awk '{ print $3 }' "$2" | grep -v 'city' | sort | uniq -c | sort -rn | head -n 3
      exit 0 ;;
    *) echo "$1 - не опция."
      exit 1;;
  esac
done
