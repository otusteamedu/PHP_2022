<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use AKhakhanova\Hw4\App;

$response = (new App())->run();
$response->send();
