#!/usr/bin/env bash

tail -n +2 table.txt | cut -f 3 -d " " | sort | uniq -c | sort -nr | head -n 3
