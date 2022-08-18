<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use NikolayTim\Dumper\Dumper;

$someArray = [
    'a' => 1,
    'b' => 2,
    'c' => 3,
];

$dumper = new Dumper();
$dumper->dump($someArray);
