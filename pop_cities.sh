#!/bin/bash

awk '{ print $3 }' < data_table.txt | sort | uniq -c | sort -nr | head  -3