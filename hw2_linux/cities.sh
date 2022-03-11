#!/bin/bash
# Otus PHP course, Leson 2: Linux basics
# Task: Find 3 most popular cities from cities list stored in file cities.txt

cat cities.txt | awk '($3 ~ /^[[:alnum:]]+$/) { ++a[$3]; } END { for (i in a) printf("%s%" (l - length(i) + 1) "s%5.2f%%\n", i, " ", (a[i])); }' | sort -r -nk2 | head -n 3 | awk '{ print $1}'


