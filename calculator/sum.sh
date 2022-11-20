#!/usr/bin/env bash
# Сложение двух чисел.

error() {
  echo -e "\033[41m\033[30m$1\033[0m"
}

result() {
  echo -e "\033[41m\033[42m$1\033[0m"
}

FIRST_NUMBER="$1"
SECOND_NUMBER="$2"

if (("$#" == 0)); then
  printf 'Enter first number: '
  read FIRST_NUMBER

  printf 'Enter second number: '
  read SECOND_NUMBER
elif (("$#" == 1)); then
  printf 'Enter second number: '
  read SECOND_NUMBER
fi

REGEXP='^[-]?[0-9]+([.][0-9]+)?$'

if ! [[ $FIRST_NUMBER =~ $REGEXP ]]; then
  error "First number \"$FIRST_NUMBER\" is NaN. Exit."

  exit
elif ! [[ $SECOND_NUMBER =~ $REGEXP ]]; then
  error "Second number \"$SECOND_NUMBER\" is NaN. Exit."

  exit
fi

if command -v awk &>/dev/null; then
  RESULT=$(awk "BEGIN {print $FIRST_NUMBER+$SECOND_NUMBER}")
elif command -v bc &>/dev/null; then
  RESULT=$(echo "$FIRST_NUMBER+$SECOND_NUMBER" | bc)
else
  error "Not tools bc and awk"
  exit
fi

result "SUM: $RESULT"

exit
