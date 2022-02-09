#!/bin/bash


function check_lib()
{
  check='dpkg -s bc | grep "Status"'
  if [ -z "$check" ]
  then
     apt-get install bc
  fi
}

function main()
{
    regexp=^-?[0-9]?[.]*[0-9]+$

    if ! [[ $1 =~ $regexp ]] || ! [[ $1 =~ $regexp ]]
    then
      echo -e "\033[31mCheckout input params";
      exit 0;
    fi

    res=$(bc<<<"$1+$2")

    echo "$res"
}

check_lib
main "$@"
