#!/usr/bin/env bash

awk '{if (NR!=1) {print $3}}' ./fixtures/towns.txt | sort -k1 | uniq -c | sort -rn | head -n 3