#!/usr/bin/env bash

. ./src/awk_sum_two_digits/services/validation_service

validate $@
validation_status=$?

sum="$(awk "BEGIN {print ($1+$2)}")"
echo $sum