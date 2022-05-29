#!/bin/bash

popularCities=$(cat ./sort_table.txt | awk '/^[0-9]/ {print $0}' | awk '{print $3}' | sort | uniq -c | sort -k1 -r | awk '{print $2}' | head -n 3)

echo "$popularCities"
