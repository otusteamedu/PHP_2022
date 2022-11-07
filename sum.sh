#!/bin/bash

re='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]] ; then
   echo "error: some var is not a number" >&2; exit 1
fi

# awk почти всегда есть в сборке Linux, в отличие от bc
awk -vvar1=$1 -vvar2=$2 'BEGIN{print var1 + var2}'