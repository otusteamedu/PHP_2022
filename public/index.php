<?php

declare(strict_types=1);

use Eliasj\Hw16\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}