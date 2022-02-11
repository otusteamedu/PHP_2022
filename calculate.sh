#!/bin/bash

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]] ; then
   echo $1+$2 | awk "BEGIN{ print $1 + $2}";
else
   echo "ERROR: Not a number";
   exit 1;
fi