#!/usr/bin/env bash

# Задача 2:
# Имеется таблица следующего вида:
# id user city phone
# 1 test Moscow 1234123
# 2 test2 Saint-P 1232121
# 3 test3 Tver 4352124
# 4 test4 Milan 7990923
# 5 test5 Moscow 908213
# Таблица хранится в текстовом файле.
# Вывести на экран 3 наиболее популярных города среди пользователей системы, используя утилиты Линукса.
# Подсказка: рекомендуется использовать утилиты uniq, awk, sort, head.

awk '{print $3}' cities.txt | sort | uniq -c | sort -r | head -3 | awk '{print $2}'