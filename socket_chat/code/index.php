<?php

declare(strict_types=1);

use Mapaxa\EmailVerificationApp\App\App;

require_once __DIR__ . '/vendor/autoload.php';

$app = new App();
$app->run();