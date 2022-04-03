<?php

require_once './../vendor/autoload.php';

$app = new \App\App();

try {
    $app->handle();
} catch (\Exception $e) {
    //
}
