#!/bin/bash

if [ "$#" != 2 ]; then
  echo "Script requires two parameters"
  exit 1
fi

sum=0
for i in $@; do
  if ! [[ $i =~ ^-?([0-9]+)([.][0-9]+)?$ ]]; then
    echo "Arguments for summation must be numbers"
    exit 1
  fi

  sum="$sum+($i)"
done

echo | awk "{ print $sum }"
