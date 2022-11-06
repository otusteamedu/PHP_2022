#!/bin/bash

awk '{if (NR!=1) {print $3}}' users | sort -k1 | uniq -c | sort -rn | head -n 3