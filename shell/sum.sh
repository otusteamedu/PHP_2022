#!/bin/bash

ARGS_QUANTITY=2
regex='^[-+]?[0-9]+\.?[0-9]*$'
BC_PKG="bc"

if [[ $# -ne $ARGS_QUANTITY ]]
then
	echo "error: Quantity of arguments should be: $ARGS_QUANTITY, get: $#" >&2
	exit 1
fi

if ! [[ $1 =~ $regex ]] || ! [[ $2 =~ $regex ]] 
then
   echo "error: One or several arguments not a number" >&2
   exit 1
fi

PKG_OK=$(dpkg-query -W --showformat='${Status}\n' $BC_PKG|grep "install ok installed")

# if bc not installed
if [ "" = "$PKG_OK" ]
then
  echo "No $BC_PKG package. This script requires package \"$BC_PKG\" to be installed"
  if read -p "Do yo want to install $BC_PKG package?" 
  then
  answer=$(echo $REPLY | tr '[:upper:]' '[:lower:]'])
	  if [[ $answer = 'y' ]] || [[ $answer = 'yes' ]]
	  then
	  echo "Installing BC_PKG"
	  sudo apt-get --yes install $BC_PKG
	  else 
  	echo "Ok. bye. Script stopped."
  	exit 1
		fi
  fi
fi

sum=$(echo "$1+$2" | bc)
echo "$1+$2=$sum"