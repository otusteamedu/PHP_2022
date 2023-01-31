<?php

/**
 * Starting page
 */

declare(strict_types=1);

use Otus\App\App;
use Otus\App\Application\Viewer\View;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    View::render('error', [
        'title' => 'Ошибка 404',
        'error_code' => '404 - Not Found',
        'result' => 'Нет такой страницы'
    ]);
}
