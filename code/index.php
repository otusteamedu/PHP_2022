<?php

use Anosovm\HW5\App;

require_once 'vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    die($e->getMessage());
}