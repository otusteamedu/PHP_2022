#!/usr/bin/env bash

echo "Insert the path to the file"

read -p "Path to file:" file

cat "$file" | awk '(NR>1) {print $3}' |
  sort |
  uniq -c |
  sort -r |
  awk '(NR<4) {print $2}'
