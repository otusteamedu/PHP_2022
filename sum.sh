#!/bin/bash

#Регулярочка
pattern="^[-]?[0-9]+([.][0-9]+)?$"

#Проверка первого аргумента
if ! [[ $1 =~ $pattern ]];then
  echo "Ошибка, первый аргумент не цифра"
  exit
fi

#Проверка второго аргумента
if ! [[ $2 =~ $pattern ]];then
  echo "Ошибка, второй аргумент не цифра"
  exit
fi

#Calculate
if command -v bc &> /dev/null
then
    echo "Результат `echo "$1+$2" | bc`"
fi