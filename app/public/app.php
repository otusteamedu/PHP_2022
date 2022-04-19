#!/usr/bin/php
<?php

use Nka\OtusSocketChat\App;

require '../vendor/autoload.php';

try {
    App::init()->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}