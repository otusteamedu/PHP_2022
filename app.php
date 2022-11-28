<?php

declare(strict_types = 1);

use Koptev\Hw6\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();

    $app->run($argv[1]);
}
catch(Exception $e) {
    echo $e->getMessage();
}
