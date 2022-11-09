#!/bin/bash

prompt="Arguments could be an integer numbers or floating point numbers(optional sign, with dot notation)"
examples="Examples: 0  -.2  1.3333  22"

#Check arguments
if ! [[ $1 =~ ^\-?[0-9]*\.?[0-9]+$ ]]; then
  echo "Error in first argument"
  echo "$prompt"
  echo "$examples"
  exit
fi

if ! [[ $2 =~ ^\-?[0-9]*\.?[0-9]+$ ]]; then
  echo "Error in second argument"
  echo "$prompt"
  echo "$examples"
  exit
fi

#Check sign & float, get number part
minusArg1=$(expr index "$1" '-')
floatArg1=$(expr index "$1" '.')
numberFromArg1=$(cut -d '-' -f 2 <<<"$1")

#Split number part to integer & float parts
integerPartArg1=$(cut -d '.' -f 1 <<<"$numberFromArg1")

if [[ $floatArg1 -gt 0 ]]; then
  floatPartArg1=$(cut -d '.' -f 2 <<<"$numberFromArg1")
else
  floatPartArg1=''
fi

#Fix empty integer part
if ! [[ $integerPartArg1 ]]; then
  integerPartArg1=0
fi

minusArg2=$(expr index "$2" '-')
floatArg2=$(expr index "$2" '.')
numberFromArg2=$(cut -d '-' -f 2 <<<"$2")

integerPartArg2=$(cut -d '.' -f 1 <<<"$numberFromArg2")

if [[ $floatArg2 -gt 0 ]]; then
  floatPartArg2=$(cut -d '.' -f 2 <<<"$numberFromArg2")
else
  floatPartArg2=''
fi

if ! [[ $integerPartArg2 ]]; then
  integerPartArg2=0
fi

#Equalize float parts & fix their length
lengthOfFloatPartArg1=$(expr length "$floatPartArg1")
lengthOfFloatPartArg2=$(expr length "$floatPartArg2")

if [[ $lengthOfFloatPartArg1 -gt $lengthOfFloatPartArg2 ]]; then
  diff=$(expr "$lengthOfFloatPartArg1" - "$lengthOfFloatPartArg2")
  equalizer=$(for ((i = 1; i <= diff; i++)); do printf "%s" "0"; done)
  floatPartArg2=$floatPartArg2$equalizer
  lengthOfFloatPart=$lengthOfFloatPartArg1
else
  diff=$(expr "$lengthOfFloatPartArg2" - "$lengthOfFloatPartArg1")
  equalizer=$(for ((i = 1; i <= diff; i++)); do printf "%s" "0"; done)
  floatPartArg1=$floatPartArg1$equalizer
  lengthOfFloatPart=$lengthOfFloatPartArg2
fi

#Restore numbers as integer
asIntegerArg1=$integerPartArg1$floatPartArg1
asIntegerArg2=$integerPartArg2$floatPartArg2

#Restore sign
if [[ $minusArg1 -gt 0 ]]; then
  asIntegerArg1=-$asIntegerArg1
fi
if [[ $minusArg2 -gt 0 ]]; then
  asIntegerArg2=-$asIntegerArg2
fi

resultAsInteger=$(expr "$asIntegerArg1" + "$asIntegerArg2")

#Echo result with float dot if need
if [[ $lengthOfFloatPart -gt 0 ]]; then
  lengthOfResultAsInteger=$(expr length "$resultAsInteger")
  lengthOfIntegerPart=$(expr "$lengthOfResultAsInteger" - "$lengthOfFloatPart")
  echo "${resultAsInteger:0:lengthOfIntegerPart}.${resultAsInteger:lengthOfIntegerPart:lengthOfResultAsInteger}"
else
  echo "$resultAsInteger"
fi
