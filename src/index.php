<?php

use TemaGo\PostRequestValidator\App;

require_once 'vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (\ErrorException $e) {

}
