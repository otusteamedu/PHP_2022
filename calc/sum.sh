#!/bin/bash

regex='^[-+]?[0-9]+\.?[0-9]*$'

if ! [[ $1 =~ $regex ]]; then
  echo "Первый параметр должен быть числом: $1"
  exit 1
fi

if ! [[ $2 =~ $regex ]]; then
  echo "Второй параметр должен быть числом: $2"
  exit 1
fi

echo $(($1 + $2));