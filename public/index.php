<?php

declare(strict_types=1);

use Eliasjump\HwStoragePatterns\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
