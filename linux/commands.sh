#!/bin/bash

regexp='^-?[0-9]([.][0-9]+)?$'

if ! [[ $1 =~ $regexp ]] || ! [[ $2 =~ $regexp ]]
then
    echo -e "Error"; exit 1;
fi

echo  $1 + $2 | bc