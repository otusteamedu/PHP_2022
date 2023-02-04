<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/..";
require ROOT . "/vendor/autoload.php";

use Nikcrazy37\Hw11\App;
use Nikcrazy37\Hw11\Exception\AppException;

try {
    $app = new App();
    $app->run();
} catch (AppException $e) {
    http_response_code($e->getCode());
    print_r($e->getMessage() . PHP_EOL);
}
