#!/bin/bash

tail -n +2 db | awk '{print $3}' | sort | uniq -c | sort -k 1nr,1 -k 2,2 | head -n 3 | awk '{print $2}'