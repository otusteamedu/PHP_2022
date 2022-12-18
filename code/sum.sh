#!/bin/bash

if ! [ -n "$1" ]
then
    echo "No parameters found. "
    exit
fi


total=0

for param in "$@"
do
  isnumber="$(echo $param | awk '/^[0-9-.]+$/{ print 1 }')"
  if [[ $isnumber -ne 1 ]]
  then
    echo "Переданы некорректные параметры"
    exit
  fi

  total="$(echo $total $param | awk '{ print $1 + $2 }')"
done

echo "Sum = $total"
