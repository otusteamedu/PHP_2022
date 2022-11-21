#!/bin/bash

awk '{if (NR!=1) {print $3}}' $1 | uniq -c | sort -frk1  | awk '{print $2 " - " "count:" $1  }' | head -n3

