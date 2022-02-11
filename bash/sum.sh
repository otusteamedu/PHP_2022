#!/bin/bash
pattern="^[+-]?[0-9]+(\.[0-9]+)?$"

if [ $# -ne 2 ]
then
echo "Warning: the program takes two numbers"
elif [[ ! $1 =~ $pattern ]]
then
echo "Warning: first parameter to be number"
elif [[ ! $2 =~ $pattern ]]
then
echo "Warning: second parameter to be number"
else
echo "Sum $1 + $2 = $[ $1 + $2 ]"
fi