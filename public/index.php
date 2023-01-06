<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ERROR);

require dirname(__DIR__) . '/vendor/autoload.php';

use AKhakhanova\Hw4\App;

$response = (new App())->run();
$response->send();
