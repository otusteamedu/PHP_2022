<?php

declare(strict_types=1);

session_start();

include('vendor/autoload.php');

use Ekaterina\Hw4\App\App;

$app = new App();
$app->run();