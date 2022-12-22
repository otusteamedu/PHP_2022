#!/usr/bin/env bash
sort -r -nk4 table.txt | awk -F" " '{ print $3 }' | head -n 3
