#!/bin/bash

if ! [ -n "$1" ]
then
    echo "No parameters found. "
    exit
fi


total=0

for param in "$@"
do
  isnumber="$(echo $param | awk '/^[0-9-.]+$/{ print "true" }')"
  if ! [[ $isnumber = true ]]
  then
    echo "Переданы некорректные параметры"
    exit
  fi

  total=$(( $total + param ))
done

echo "Sum = $total"
