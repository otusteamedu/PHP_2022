<?php

use App\App;

require_once('vendor/autoload.php');

try {
    $app = new App();
    $app->run($argv);
} catch (Exception $e) {
    print_r('Ошибка при выполнении программы' . PHP_EOL);
    print_r($e->getMessage());
}
