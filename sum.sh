#!/bin/bash

if [ "$1" == "-help" ] || [ "$1" == "--help" ]; then
  echo "This script sums two numbers"
  exit 0
fi

if [ "$#" != 2 ]; then
  echo "This script requires two parameters"
  exit 1
fi

sum=0
for i in $@; do
  if ! [[ $i =~ ^-?([0-9]+)([.][0-9]+)?$ ]]; then
    echo "Аргументы для суммирования должны быть числами: \"$i\" таковым не вляется."
    exit 1
  fi

  sum="$sum+($i)"
done

if command -v bc &>/dev/null; then
  echo $sum | bc -l | sed -r -e 's/^([-])?([.])/\10\2/'
  exit 0
fi

if command -v gnome-calculator &>/dev/null; then
  echo $(gnome-calculator -s $sum)
  exit 0
fi

if command -v awk &>/dev/null; then
  echo | awk "{ print $sum }"
  exit 0
fi

echo "Для выполнения этой операции требуется установить один из пакетов: «bc», «gnome-calculator», «original-awk»."
exit 1
