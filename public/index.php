<?php

require(__DIR__) . '/vendor/autoload.php';

use App\Application\Application;

try {
    (new Application())->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

