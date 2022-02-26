<?php

use Unixsocket\App\Core\App;

require 'vendor/autoload.php';

try {
    $app = new App();
    $app->run($argv);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
