#!/bin/bash

if [ ! -f $1 ]
then
  echo $1 is not a file
  exit
fi

cat $1 | tail -n +2 | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}'