#!/bin/bash
head -n 1 table.txt && sed '1d' table.txt | awk 'BEGIN{echo "head table.txt"} {print $0}' | sort -t' ' -nrk4 | head -n 3