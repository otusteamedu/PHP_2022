#!/bin/bash

arg1=1
arg2=3
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"

arg1=-1
arg2=9
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"

arg1=-1.0
arg2=9
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"

arg1=-1
arg2=-9.8799787979
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"

arg1=-1.0000000001
arg2=-.8
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"


arg1=1.0000000001
arg2=.8999999999999
bcResult=$(./sum.sh $arg1 $arg2)
sumHardResult=$(./sum_hard.sh $arg1 $arg2)
echo "With  bc $arg1 + $arg2 = $bcResult"
echo "Sum_hard $arg1 + $arg2 = $sumHardResult"
echo "--------------------------------------"