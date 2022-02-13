#!/bin/bash
awk '{print $3}' cities | sort | uniq -c | sort -r -k1 | head -n 3
