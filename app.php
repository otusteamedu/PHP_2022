<?php

use Otus\Core\App;

require_once __DIR__ . '/vendor/autoload.php';

try {
    App::run();
} catch (Exception $e) {
    dump($e->getMessage());
}