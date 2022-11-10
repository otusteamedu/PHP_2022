#!/bin/bash

if [ "$#" != 2 ]; then
  echo "Необходимо передать два числа"
  exit 1
fi

regex="^[-]?[0-9]*[.]?[0-9]*$"
if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]] ;
then
   echo $1+$2 | awk "{ print $1 + $2}";
else
   echo "Аргументами могут быть только числа";
   exit 1;
fi