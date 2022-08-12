#!/bin/bash

# Удаляем промежуточный файл
rm tmp.txt

uniqueCities=$(cat sort.txt | awk '{print $3}' | sort -u)
echo 'Уникальные наименования городов:' $uniqueCities

for city in $uniqueCities; do
  count=$(cat sort.txt | awk '{print $3}' | grep $city -c )

  # Добавляем в промежуточный файл строку: кол-во строк с городом и наименование города
  echo "$count $city" >> tmp.txt
done

popularCities=$(cat tmp.txt | sort -nk1 -r | awk '{print $2}' | head --lines=3)
echo 'Наиболее популярные города:' $popularCities
