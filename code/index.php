<?php

require "vendor/autoload.php";

use Nsavelev\Hw5\App\App;

$app = new App();

try {
    echo $app->handle();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}
