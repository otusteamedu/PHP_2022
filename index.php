<?php

declare(strict_types=1);

require 'vendor/autoload.php';
$app = new App();
isset($argv[1]) ? $app->run($argv[1]) : $app->run();
