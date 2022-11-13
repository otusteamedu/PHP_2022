#!/bin/bash

file=user_data
countCities=3

awk '{{if (NR>1) {print $3}}}' $file | sort | uniq -c | sort -rk 1 | head -n $countCities