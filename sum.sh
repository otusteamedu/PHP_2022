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
echo $FIRST_NUMBER' '$SECOND_NUMBER | awk -F' ' '{sum+=$1+$2;} END{print sum;}'

