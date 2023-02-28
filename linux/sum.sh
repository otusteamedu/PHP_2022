#!/bin/bash
re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
    echo "Ошибка->Это не число" >&1; exit 1
fi
if ! [[ $2 =~ $re ]] ; then
    echo "Ошибка->Это не число" >&1; exit 1
fi
awk "BEGIN{ print $1 + $2 }"