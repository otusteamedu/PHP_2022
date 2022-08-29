#!/usr/bin/bash

regex='^[-+]?[0-9]+\.?[0-9]*$'

if ! [[ $1 =~ $regex ]]; then
  echo "First param '$1' is not a number"
  exit 1
fi

if ! [[ $2 =~ $regex ]]; then
  echo "Second param '$2' is not a number"
  exit 1
fi

echo "$(awk "BEGIN {print ($1+$2)}")"
