#!/bin/bash

if [ ! $# -eq 1 ]; then
  echo Wrong parameters number, file should be set
  exit
fi

if [ ! -r "$1" ]; then
  echo "$1" does not exist or can not be read
  exit
fi

tail -n +2 "$1" | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}'
