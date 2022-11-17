<?php

require __DIR__ . '/vendor/autoload.php';

use Klykovrv\NaturalNumberDivisorsPackage\NaturalNumberDivisors;

echo NaturalNumberDivisors::getDivisors(3);
echo "<hr>";
echo NaturalNumberDivisors::getDivisors(20);
echo "<hr>";
echo NaturalNumberDivisors::getDivisors(1);
echo "<hr>";
try {
    echo NaturalNumberDivisors::getDivisors(0);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "<hr>";
try {
    echo NaturalNumberDivisors::getDivisors(-2);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "<hr>";
try {
    echo NaturalNumberDivisors::getDivisors(1.5);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "<hr>";
try {
    echo NaturalNumberDivisors::getDivisors("aaa");
} catch (Exception $e) {
    echo $e->getMessage();
}
