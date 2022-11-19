<?php

use AndreyKoptev\FirstPackage\Calculator;

$a = random_int(1, 100);
$b = random_int(1, 100);

$calc = new Calculator();

echo $calc->add($a, $b);
echo PHP_EOL;

echo $calc->sub($a, $b);
echo PHP_EOL;

echo $calc->mul($a, $b);
echo PHP_EOL;

echo $calc->div($a, $b);
echo PHP_EOL;
