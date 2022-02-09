#!/usr/bin/env bash

pattern='^[+-]?([0-9]+\.?|[0-9]*\.[0-9]+)$'

read -p "First operand:" first
read -p "Second operand:" second

if ! [[ $first =~ $pattern ]]; then
  echo "$first - param not a number"
  exit 1
fi

if ! [[ $second =~ $pattern ]]; then
  echo "$second - not a number"
  exit 1
fi

echo "Result: $(awk "BEGIN {print ($first+$second)}")"
