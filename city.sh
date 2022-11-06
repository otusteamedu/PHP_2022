#!/bin/bash
fileName="users.csv"

#Проверка на существования файла
if ! [ -e $fileName ] || ! [ -s $fileName ]
then
  echo "Файл не найден"
  exit
fi

echo "Три популярных города:"
sed -n '2,$'p $fileName | awk '{ print $3 }' | sort | uniq -c | sort -r | awk '{ print $2 }' | head -n3