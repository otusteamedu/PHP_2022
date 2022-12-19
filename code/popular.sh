#!/bin/bash

awk '{print $3}' file.txt | tail --lines +2 | sort | uniq -c | sort -r | head --lines 3 | awk '{print $2}'