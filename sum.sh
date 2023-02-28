#!/bin/bash

reg='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $reg ]] || ! [[ $2 =~ $reg ]] ; then
   echo "error: Not a number"; exit 1
fi

calc(){ awk "BEGIN { print $*}"; }
calc $1+$2
