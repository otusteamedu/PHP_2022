#!/bin/bash

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]] ; then
   var calc=$1+$2;
   echo $calc;
else
   echo "ERROR: Not a number";
   exit 1;
fi