#!/bin/env bash

awk '{if (NR!=1) {print $3}}' table.txt | sort | uniq -c | sort -k 1 -r | awk '{print $2}' | head -3
