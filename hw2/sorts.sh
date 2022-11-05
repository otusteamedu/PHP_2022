#!/bin/bash

uniq data.txt | awk '($3 ~ /^[[:alnum:]]+$/) { a[$3]; } END { for (i in a) printf("%s%" "s", i, " "); }' | sort -nk3 | head -n 3