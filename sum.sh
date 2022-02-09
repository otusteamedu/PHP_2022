#!/bin/bash
re='^[0-9]+$'
if ! [[ $1 =~ $re ]] ; then
    echo "error: Not a number" >&1; exit 1
fi
if ! [[ $2 =~ $re ]] ; then
    echo "error: Not a number" >&1; exit 1
fi
sum=$(( $1 + $2 )) 
    echo "Sum is: $sum"
