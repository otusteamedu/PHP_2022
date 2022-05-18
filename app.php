<?php

declare(strict_types=1);

require 'vendor/autoload.php';

try {
    (new App())->run();
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}