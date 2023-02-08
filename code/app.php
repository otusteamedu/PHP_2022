<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Kogarkov\Chat\App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
