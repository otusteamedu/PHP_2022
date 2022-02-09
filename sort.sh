#!/bin/bash

if [ $(dpkg-query -W -f='${Status}' awk 2>/dev/null | grep "ok installed") -eq 0 ];
then
  apt-get install awk;
fi

cat './data.txt' |
  awk '{ print $3 }' | # cities column
  sort |
  uniq -c | # unique count
  sort -r # reverse