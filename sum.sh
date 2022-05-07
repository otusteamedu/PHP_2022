#!/bin/bash

function checkArg {
  if [[ ! $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
  then
    echo Argument \"$1\" is not a number
    exit
  fi
}

checkArg $1
checkArg $2

awk "BEGIN { print $1+$2}"

