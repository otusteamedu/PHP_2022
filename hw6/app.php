<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Veraadzhieva\Hw6\App($argv);
    $app->run();
}
catch(Exception $e) {
    echo $e->getMessage();
}