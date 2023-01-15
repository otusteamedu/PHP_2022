<?php

$sum = static fn(int $a, int $b): int => $a + $b;
$join = static fn(string $a, string $b) => $a . $b;

$calc = function ($item) use (&$calc) {
    static $args = [];
    if (\is_callable($item)) {
        $array = $args;
        $args = [];
        $initial = \array_shift($array);
        return \array_reduce($array, $item, $initial);
    }

    $args[] = $item;

    return $calc;
};

echo $calc(1)(2)($sum) . PHP_EOL; // 3
echo $calc(1)(2)(7)($sum) . PHP_EOL; // 10
echo $calc('a')('b')('c')('d')($join) . PHP_EOL; // abcd
