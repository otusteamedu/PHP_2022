#!/usr/bin/env bash

if [[ $# -ne 2 ]]; then
    echo ERROR: The number of arguments must be equal to two
	exit 1

fi

if ! [[ $1 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]; then
    echo ERROR: The argument number one not number
    exit 1
fi

if ! [[ $2 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]; then
    echo ERROR: The argument number two not number
    exit 1
fi


sum=` echo "$1   $2" | awk '{print $1 + $2}'`

echo "result: $1 + $2 = "$sum