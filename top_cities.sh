#!/usr/bin/env bash

awk '{print $3}' ./users.txt | sed 1d | sort | uniq -c | sort -r | head -n3 | awk '{print $2}'
