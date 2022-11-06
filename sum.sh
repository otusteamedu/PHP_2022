#!/usr/bin/env bash

FIRST_NUMBER=$1;
SECOND_NUMBER=$2;

if [[ ! "$FIRST_NUMBER" =~ ^[0-9]+$ ]]; then
    echo "Invalid first number";
    exit;
fi

if [[ ! "$SECOND_NUMBER" =~ ^[0-9]+$ ]]; then
    echo "Invalid second number";
    exit;
fi

echo "SUM: $FIRST_NUMBER + $SECOND_NUMBER == $(($FIRST_NUMBER+$SECOND_NUMBER))";