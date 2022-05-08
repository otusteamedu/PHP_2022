#!/bin/bash

if [ ! $# -eq 2 ]; then
  echo Wrong parameters number, should be two parameters
  exit
fi

function checkParam {
  if [[ ! $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
    echo \""$1"\" is not a number
    exit
  fi
}

checkParam "$1"
checkParam "$2"

awk "BEGIN{print $1 + $2}"
