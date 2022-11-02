#!/bin/bash

if ! command -v bc &> /dev/null
then
    echo "bc package not found. Please install bc to run the program"
    exit
fi

prompt="Arguments could be an integer numbers or floating point numbers(optional sign, with dot notation)"

if ! [[ $1 =~ ^\-?[0-9]*\.?[0-9]+$ ]]; then
   echo "Error in first argument"
   echo $prompt
   exit
fi

if ! [[ $2 =~ ^\-?[0-9]*\.?[0-9]+$ ]]; then
   echo "Error in second argument"
   echo $prompt
   exit
fi

echo $(echo "$1+$2" | bc)