#!/usr/bin/env bash

if [[ ! ("$#" == 2 && $1 =~ ^[+-]?[0-9]+\,?[0-9]*$ && $2 =~ ^[+-]?[0-9]+\,?[0-9]*$) ]]; then
    echo 'Please enter 2 arguments - digits'
    exit 1
fi

echo $1 $2 | awk  '{ print $1 + $2  }'