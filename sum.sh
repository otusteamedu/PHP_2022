#!/bin/bash

re='[+-]?[0-9]([.][0-9]+)?$'
I=`dpkg -s bc | grep "Status"`

if [[ $# -ne 2 ]]
then
  echo "Должно быть 2 аргумента"
else
  if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]]
  then
    echo "Аргументы должны быть целым или вещественным числом"
  else
    echo $1 $2 | awk '{print $1 + $2}'
  fi
fi