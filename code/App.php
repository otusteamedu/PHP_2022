<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Nikolai\Php\Application;

try {
    $app = new Application();
    $app->run();
}
catch(Exception $e){
    fwrite(STDOUT, 'Исключение: ' . $e->getMessage() . PHP_EOL);
}