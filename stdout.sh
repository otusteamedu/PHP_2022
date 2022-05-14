#!/bin/bash

cat db.txt | awk '{print $3}' | sort | uniq -c | head --lines=-1 | sort -r -nk1 -k2 | head -n 3