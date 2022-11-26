sort ./city.txt -k 4nr | uniq -f3 | head -n 3 | awk '{print NR,$2, $3, $4}'
