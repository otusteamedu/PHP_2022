#!/bin/bash

awk '{ print $3}' table.txt | tail -n +2 | sort | uniq -c | sort -k1 -r | head -n 3