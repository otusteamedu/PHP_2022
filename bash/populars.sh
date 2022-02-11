#!/bin/bash

sed '1d' < db.txt | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk 'BEGIN {print "Popular city:"} {print $2}'