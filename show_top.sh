#!/bin/bash

awk '{if(NR>1) print $3}' $1 | sort -k 1 | uniq -c | sort -k1 -nr| head -n 3

