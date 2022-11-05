#!/bin/bash
fileName="users.txt"

#check not or empty file
if ! [ -e $fileName ] || ! [ -s $fileName ]
then
  echo "Error: File users.txt not found or empty"
  exit
fi

echo "Three most popular cities:"
cut -d ' ' -f3 $fileName | tail +2 | sort | uniq -ic | sort -nr | head -n 3 | awk '{print $2}'