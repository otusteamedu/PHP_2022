<?php

use Nemizar\Php2022\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
}
