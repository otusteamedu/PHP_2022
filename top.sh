#!/usr/bin/env bash
tail -n +2 table.txt | awk '{ print $3 }' | sort | uniq -c | sort -nr | awk '{ print $2 }' | head -n 3