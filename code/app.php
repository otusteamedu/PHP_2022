<?php

declare(strict_types=1);
const ROOT = __DIR__;
require ROOT . "/vendor/autoload.php";

use Nikcrazy37\Hw6\App;
use Nikcrazy37\Hw6\Exception\AppException;

try {
    $app = new App($argv[1]);
    $app->run();
} catch (AppException $e) {
    print_r($e->getMessage() . PHP_EOL);
}