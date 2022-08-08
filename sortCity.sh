#!/bin/bash

tail -n +2 './city.txt' | sort | awk '{print $3}' | uniq -c | head -3

