#!/bin/bash

reg='^[-]?[0-9]+([.][0-9]+)?$'
total=0
for i in "$@"; do
  if ! [[ $i =~ $reg ]]; then
    echo "$i error: Not valid number" >&2
    exit 1
  fi
  total=$(echo "$total $i" | awk '{print $1 + $2}')
done

echo "Sum is $total"
