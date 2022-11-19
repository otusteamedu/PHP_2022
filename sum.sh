#!/bin/bash

echo "Enter Two numbers :"
read a
read b

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $a =~ $re && $b =~ $re ]] ; then
   echo "error: Not a number" >&2; exit 1
fi

res=`echo "$a" + "$b" | bc`

echo  "Result:";
echo  $res;