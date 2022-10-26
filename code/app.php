<?php

require "vendor/autoload.php";

use Nsavelev\Hw6\App\App;

$app = new App();

try {
    echo $app->run($argc, $argv);
} catch (\Exception $exception) {
    echo $exception->getMessage() . "\n";
}
