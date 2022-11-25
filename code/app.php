<?php

declare(strict_types=1);

use Pinguk\Chat\App;

require_once('./vendor/autoload.php');

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
}
