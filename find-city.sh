#!/bin/bash
# This is script for find most popular city in file table.txt

awk '{print $3}' table.txt | sort -k1 | uniq -c | sort -rn | head -n 3
