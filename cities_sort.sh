#!/bin/bash
if [[ -e $1 ]]
then
    awk '{print $3}' $1 | sort -k1 | uniq -c | head -n3 | sort -k1 -r
else 
    echo 'Укажите первым параметром существующий файл'
fi
