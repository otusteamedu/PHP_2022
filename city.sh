#!/bin/bash

sed -n '2,$'p testfile | awk '{ print $3 }' | sort | uniq -c | sort -r | awk '{ print $2 }' | head -n3
