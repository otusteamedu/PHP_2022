#!/usr/bin/env bash

if [ "$1" == "-help" ] || [ "$1" == "--help" ] || [ "$#" != 2 ]; then
  echo "Pass two numbers to sum them"
  exit 0
fi

for i in $@; do
  if ! [[ $i =~ ^-?([0-9]+)([.][0-9]+)?$ ]]; then
    echo "Need numbers/floats"
    exit 1
  fi
done

if command -v awk &>/dev/null; then
  echo | awk "{ print $1 + $2 }"
  exit 0
fi

echo "Need package original-awk"
exit 1