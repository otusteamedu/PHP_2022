#!/bin/bash

cat "users.txt" | awk '!/city/ {print $3}' | sort | uniq -c | sort -r | awk '{print $2 " - " $1}' | head -n 3
