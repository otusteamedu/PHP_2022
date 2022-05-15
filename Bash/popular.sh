#!/bin/bash
file='./Bash/table.txt'
file2='./Bash/tmpfile.txt'
cat $file | awk '{print $3}' | sort | uniq -c | sort -nr > tmpfile; mv tmpfile $file2
head -1 $file2
