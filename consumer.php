<?php

declare(strict_types=1);

use Eliasj\Hw16\AppConsumer;

require __DIR__ . '/vendor/autoload.php';

try {
    (new AppConsumer())->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}