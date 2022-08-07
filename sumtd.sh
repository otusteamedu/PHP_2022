#!/usr/bin/env bash

. ./src/sum_two_digits/services/validation_service

validate $@ #передаем все параметры командной строки в функцию
validation_status=$?

if  (exit $status); then
    echo "$1 + $2" | bc
fi
