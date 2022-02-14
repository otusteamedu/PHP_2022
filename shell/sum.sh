#!/bin/bash

ARGS_QUANTITY=2
regex='^[-+]?[0-9]+\.?[0-9]*$'
BC_PKG="bc"
COUNT_TRIES_TO_INSTALL_PKG=3


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
fact_tries_of_install=0
while [ "" = "$PKG_OK" ]
do

  echo "No $BC_PKG package. This script requires package \"$BC_PKG\" to be installed"
  if read -p "Do yo want to install $BC_PKG package?" 
  then
  answer=$(echo $REPLY | tr '[:upper:]' '[:lower:]'])
	  if [[ $answer = 'y' ]] || [[ $answer = 'yes' ]]
	  then
	  echo "Installing $BC_PKG"
	  sudo apt-get --yes install $BC_PKG
	  PKG_OK=$(dpkg-query -W --showformat='${Status}\n' $BC_PKG|grep "install ok installed")
	  else 
  	echo "Script stopped. Reason: $BC_PKG was not installed."
  	exit 1
		fi
  fi
  COUNT_TRIES_TO_INSTALL_PKG=$[ $COUNT_TRIES_TO_INSTALL_PKG - 1 ]
  fact_tries_of_install=$[ $fact_tries_of_install + 1 ]

  if [ $COUNT_TRIES_TO_INSTALL_PKG -eq 0 ]
  then
      echo "$BC_PKG was not installed after $fact_tries_of_install tries. Try later."
      exit 1
  fi
  /bin/sleep 1
done


if [ "install ok installed" = "$PKG_OK" ]
then
    sum=$(echo "$1+$2" | bc)
    echo "$1+$2=$sum"
else
    echo "Script stopped. Reason: $BC_PKG was not installed."
fi