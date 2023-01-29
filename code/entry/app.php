<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/..";
require ROOT . "/vendor/autoload.php";

use Nikcrazy37\Hw10\App;
use Nikcrazy37\Hw10\Exception\AppException;

try {
    $app = new App();
    $app->run();
} catch (AppException $e) {
    print_r($e->getMessage() . PHP_EOL);
}