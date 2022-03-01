<?php

declare(strict_types=1);

use Kirillov\App;

require __DIR__ . '/config/bootstrap.php';

$app = new App();
$app->run();