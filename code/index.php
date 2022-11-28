<?php
require_once __DIR__.'/vendor/autoload.php';

use Ppro\Hw5\App;

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}