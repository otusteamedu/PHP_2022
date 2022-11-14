#!/bin/bash

argsCount=2

if [[ $# -ne $argsCount ]]
then
        echo "ERROR: Count args must be equal to $argsCount, but entered $#"
        exit 1
fi

if ! [ -x "$(command -v bc)" ]
then
        echo "ERROR: Package bc is not installed. Install via \"apt install bc\""
        exit 1
fi


reg='^-?[0-9]+([.][0-9]+)?$'
for i in $@
do
        if ! [[ $i =~ $reg ]]
        then
                echo "ERROR: \"$i\" - not a number" >&2;
                exit 1
        fi
done

sum=$( awk "BEGIN { print ( $1 + $2 ) }" )
echo "$1 + $2 = $sum"