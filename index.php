<?php

use Numb666\OtusComposerPackage\StringShuffle;

$str = 'string';
$processor = new StringShuffle();
echo $processor->shuffle($str); // result -> gtirsn
