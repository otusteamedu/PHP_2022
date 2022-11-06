#!/bin/bash

SUM=0;
RESULT="";

for i in $@; do

	if [[ "$RESULT" = "" ]]
	then
		RESULT=$i;
	else
		RESULT="$RESULT + $i";
	fi
	
	
	CHECK="$(echo $i | awk '/^[0-9-.]+$/{ print "correct" }')"

	if [[ $CHECK = "correct" ]]
	then
		SUM="$(echo $SUM $i | awk '{ print $1 + $2 }')";
	else
		echo "Некорректный аргумент - $i"
		exit 1;
	fi

done

RESULT="Сумма чисел: $RESULT = $SUM";
echo $RESULT;

exit 0;