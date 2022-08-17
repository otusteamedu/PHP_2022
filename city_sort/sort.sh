#!/usr/bin/env bash

cat city.txt | awk '{print $3}' |  sort |  uniq -c | sort -nrk1 | head -n3