#!/usr/bin/env bash

function max {
  if [[ $1 -gt $2 ]] ; then
    echo $1
  else
    echo $2
  fi
}

function toZero {
  if [[ $1 == "" ]] ; then
    echo 0
  else
    echo $1
  fi
}

function bigNum {
  size1=${#1}
  size2=${#2}
  size=$(max $size1 $size2)
  num=""
  for (( i = 0; i < $((size-size1)); i++ )); do
    num="${num}0"
  done
  echo "${num}${1}"
}

function bigFrac {
  num="${1}"
  for (( i = 0; i < $(($3-$2)); i++ )); do
    num="${num}0"
  done
  echo "${num}"
}

function trimLeft {
  result=$1
  for (( i = 0 ; i <= $2 ; i++ )); do
    result=${result#"0"}
  done
  echo $result
}

function trimRight {
  result=$1
  for (( i = 0 ; i <= $2 ; i++ )); do
    result=${result%"0"}
  done
  echo $result
}

function plus {
  size=${#1}
  result=""
  next=0
  for (( i = $size - 1; i >= 0; i-- )); do
    digit1=${1:$i:1}
    digit2=${2:$i:1}
    s=$((next + digit1 + digit2))
    next=$((s/10))
    digit=$((s%10))
    result="${digit}${result}"
  done
  if [[ $next == 1 ]] ; then
    result="${next}${result}"
  fi
  echo $result
}

function minus {
  size=${#1}
  result=""
  next=0
  for (( i = $size - 1; i >= 0; i-- )); do
    digit1=${1:$i:1}
    digit2=${2:$i:1}
    s=$((digit1 - digit2 - next))
    if [[ $s -lt 0 ]] ; then
      digit=$((10 + s))
      next=1
    else
      digit=$s
      next=0
    fi
    result="${digit}${result}"
  done
  echo $(trimLeft $result $size)
}

RE="^(-?)([0-9]*)(\.?)([0-9]*)$"

if [[ $# == 2 ]] ; then
  if [[ $1 =~ $RE ]] ; then
    sign1=${BASH_REMATCH[1]}
    var1=${BASH_REMATCH[2]}
    var3=${BASH_REMATCH[4]}
    var3=$(toZero $var3)

    if [[ $2 =~ $RE ]] ; then
      sign2=${BASH_REMATCH[1]}
      var2=${BASH_REMATCH[2]}
      var4=${BASH_REMATCH[4]}
      var4=$(toZero $var4)

      scale1=${#var3}
      scale2=${#var4}
      scale=$(max $scale1 $scale2)

      bigInt1=$(bigNum $var1 $var2)
      bigInt2=$(bigNum $var2 $var1)
      sizeInt=${#bigInt1}

      bigFrac1=$(bigFrac $var3 $scale1 $scale)
      bigFrac2=$(bigFrac $var4 $scale2 $scale)

      bigNum1=$"${bigInt1}${bigFrac1}"
      bigNum2=$"${bigInt2}${bigFrac2}"

      if [[ $sign1 == $sign2 ]]; then
        bigResult=$(plus $bigNum1 $bigNum2)
        sign=""
      else
        if [[ ${bigNum2#0} -ge ${bigNum1#0} ]]; then
          bigResult=$(minus $bigNum2 $bigNum1)
          if [[ $sign2 == "-" ]]; then
            sign="-"
          else
            sign=""
          fi
        else
          bigResult=$(minus $bigNum1 $bigNum2)
          if [[ $sign1 == "-" ]]; then
            sign="-"
          else
            sign=""
          fi
        fi
      fi

      int=${bigResult:0:$((-1 * scale))}
      frac=${bigResult:$((-1 * scale))}
      frac=$(trimRight $frac $scale)

      if [[ $int == "" ]]; then
        int="0"
      fi

      if [[ $frac == "" ]]; then
        frac="0"
      fi

      echo "sum = ${sign}${int}.${frac}"
    else
      echo "Invalid second parameter"
    fi
  else
    echo "Invalid first parameter"
  fi
else
  echo "You have to enter 2 parameters"
fi
