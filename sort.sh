#!/bin/bash

utilities="sort uniq head"
for utility in $utilities; do
  if ! command -v "$utility" &> /dev/null; then
      echo "Ошибка! Для работы с этим приложением вам необходимо установить утилиту $utility."
      echo "Для установки выполните следующие команды:"
      echo "apt-get update"
      echo "apt-get install $utility"
      exit
  fi
done

filename=tbl_users.txt
awk 'FNR>1{print $3}' $filename | sort | uniq -c | sort -r | head -3 | awk '{print $2}'