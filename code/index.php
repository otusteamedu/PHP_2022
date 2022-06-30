<?php

require "vendor/autoload.php";

use Nsavelev\Hw4\App\App;

$app = new App();

try {
    echo $app->handle();
} catch (\Exception $exception) {
    http_response_code(520);

    echo $exception->getMessage();
}
