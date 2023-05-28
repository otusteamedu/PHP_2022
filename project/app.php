<?php

declare(strict_types=1);

require_once('/vendor/autoload.php');

use Rehkzylbz\OtusHw7\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    
}
