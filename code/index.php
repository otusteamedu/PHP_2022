<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$app = new \Sveta\Code\App();
print_r($app->run());
