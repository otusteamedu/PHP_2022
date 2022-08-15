#!/usr/bin/env bash

for p in $(awk '{print $3}' users.txt | sort | uniq -c | sort -rn | head -n 3)
do
  echo $p
done;