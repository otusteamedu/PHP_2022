<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Octopus\App\App;

try {
    (new App())->run();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}