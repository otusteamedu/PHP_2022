<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use App\Application;

$App = new Application\App();

try {
    $App->run();
} catch(\Exception $exception) {
    echo "Произошла ошибка: " . $exception->getMessage();
}