#!/bin/bash
cat city.txt | awk '{ print $3 }' | grep -v 'city' | sort | uniq -c | sort -r | head -n 3