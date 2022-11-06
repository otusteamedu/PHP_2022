#!/bin/bash

awk 'NR == 1 { next }
	{ a[$3] += 1 }
	END {
		for (i in a) {
			printf "%s\t%s\n", i, a[i];
		}
    }
' ./test.txt | sort -nrk2 | awk 'NR > 3 { next } { print $1 }'