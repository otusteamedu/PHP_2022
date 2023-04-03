<?php

declare(strict_types=1);

use Svatel\Code\App;

include __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Произошла ошибка';
}
