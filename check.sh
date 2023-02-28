#!/bin/bash

if [ "$#" -eq 0 ]; then
    echo "Please provide arguments"
fi

cities=()
while read id user city phone; do
        cities+=("$city")
done < "$1"

top1_result="city"
top1_max_count=0

top2_result="city"
top2_max_count=0

top3_result="city"
top3_max_count=0

count_city=0
for count_city in ${cities[*]}; do
    count=0
    for city in ${cities[*]}; do
        if [[ $city =~ $count_city ]]; then
            (( count++ ))
        fi
    done
    if (( $top1_max_count < $count )); then
        top1_result="$count_city"
        top1_max_count="$count"
    fi

    if (( $top2_max_count < $count )) && ((count <= $top1_max_count )) && [[ $count_city != $top1_result ]]; then
        top2_result="$count_city"
	top2_max_count="$count"
    fi

    if (( $top3_max_count < $count )) && ((count <= $top1_max_count )) && ((count <= $top2_max_count )) && [[ $count_city != $top1_result ]] && [[ $count_city != $top2_result ]]; then
        top3_result="$count_city"
	top3_max_count="$count"
    fi

done

echo "1) $top1_result 2) $top2_result 3) $top3_result"