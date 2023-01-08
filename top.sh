#!/usr/bin/env bash

awk '{ print $3 }' < users.txt | sort | uniq -c | sort -nr | head  -3