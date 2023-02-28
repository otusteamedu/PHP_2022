#!/bin/bash
# Calculate the sum via command-line arguments
# $1 and $2 refers to the first and second argument passed as command-line arguments


re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
   echo "error: First param not a number" >&2; exit 1
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $2 =~ $re ]] ; then
   echo "error: Second param not a number" >&2; exit 1
fi

x="$1"
y="$2"
sum="$( bc <<<"$x + $y" )"

echo "Sum of $1 and $2 is: $sum"

