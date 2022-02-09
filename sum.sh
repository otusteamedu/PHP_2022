#!/bin/bash

if [ $(dpkg-query -W -f='${Status}' bc 2>/dev/null | grep "ok installed") -eq 0 ];
then
  apt-get install bc;
fi

reg='^[+-]?[[:digit:]]+\.?[[:digit:]]*$'

if ! [[ $1 =~ $reg ]] || ! [[ $2 =~ $reg ]]; then
  echo "Wrong arguments. Only digits available.";
  exit 1;
fi

printf 'sum = %f\n' "$( printf '%f + %f\n' "$1" "$2" | bc )"