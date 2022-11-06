#!/usr/bin/env bash

FIRST_NUMBER=$1;
SECOND_NUMBER=$2;

if [[ ! "$FIRST_NUMBER" =~ ^-?([0-9])+\.?([0-9]+)$ ]]; then
    echo "Invalid first number";
    exit;
fi

if [[ ! "$SECOND_NUMBER" =~ ^-?([0-9])+\.?([0-9]+)$ ]]; then
    echo "Invalid second number";
    exit;
fi

# Вариант с bc
bc <<< "$FIRST_NUMBER+$SECOND_NUMBER"

# Вариант без bc
#cut -d . -f 2 <<< "345.657"
IFS='.' read -r -a split <<< "$FIRST_NUMBER"
FIRST_NUMBER=${split[0]}${split[1]}
FIRST_DECIMAL=${#split[1]}

IFS='.' read -r -a split <<< "$SECOND_NUMBER"
SECOND_NUMBER=${split[0]}${split[1]}
SECOND_DECIMAL=${#split[1]}

# добиваемся единой разрядности
if [ $FIRST_DECIMAL -gt $SECOND_DECIMAL ]; then
  DECIMAL=$FIRST_DECIMAL
  DIFF=$(($FIRST_DECIMAL-$SECOND_DECIMAL))
  for i in $(seq $DIFF); do
    SECOND_NUMBER="${SECOND_NUMBER}0"
  done
fi

# добиваемся единой разрядности
if [ $SECOND_DECIMAL -gt $FIRST_DECIMAL ]; then
  DECIMAL=$SECOND_DECIMAL
  DIFF=$(($SECOND_DECIMAL-$FIRST_DECIMAL))
  for i in $(seq $DIFF); do
    FIRST_NUMBER="${FIRST_NUMBER}0"
  done
fi

SUMMA=$(($FIRST_NUMBER+$SECOND_NUMBER))
COUNT_SYMBOLS=$((${#SUMMA}-DECIMAL))
COUNT_SYMBOLS_NEXT=$(($COUNT_SYMBOLS+1))

echo $( echo $SUMMA | cut -b -$COUNT_SYMBOLS)'.'$( echo $SUMMA | cut -c $COUNT_SYMBOLS_NEXT-)

