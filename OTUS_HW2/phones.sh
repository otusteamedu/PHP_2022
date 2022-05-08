#!/bin/bash
#Выводим самые популярные телефоны из текстового файла
#id user city phone 
cat ./users.txt | awk {'print $4'} | grep -v "phone" | uniq -c | sort -n -r | awk {'print $2'}