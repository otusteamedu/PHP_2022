#!/bin/bash

osDistrLike=$(cat /etc/os-release 2> /dev/null | grep "ID_LIKE")

case $osDistrLike in
*"rhel"*)
  osManagerCheck='rpm -qi';
  ;;
*"debian"*)
  osManagerCheck='dpkg -s';
  ;;
*)
echo "Not supported OS"
exit
;;
esac

isBc=$($osManagerCheck bc 2> /dev/null | grep "Version" )

if [ -n "$isBc" ]
then
  if [ $# == 2 ]
  then
    regex='^[+-]?[0-9]+([.][0-9]+)?$'
    count=1
    err=0
    for param in "$@"
    do
      if ! [[ $param =~ $regex ]]
      then
        echo "Parameter #$count must be a real number" >&2
        err=1
      fi
    count=$(( $count + 1 ))
    done

    if [ $err == 0 ]
    then
      sum=$(bc<<<"$1+$2")
      echo "Sum: $sum"
    fi
  else
    echo You must enter two numeric parameters
  fi
else
  echo "bc is not installed"
  exit
fi


