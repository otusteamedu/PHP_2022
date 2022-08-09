#!/bin/bash

tail -n +2 /var/www/PHP_2022/city.txt | sort | awk '{print $3}' | uniq -c | head -3

