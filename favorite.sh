#!/bin/bash

awk '{if (NR!=1) {print $3}}' table.txt | sort -k1 | uniq -c | sort -r | head -n3