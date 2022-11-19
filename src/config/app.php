<?php

declare(strict_types=1);

use Slim\App;
use Slim\Factory\AppFactory;

return static function (): App {
    $app = AppFactory::create();
    (require __DIR__ . '/routes.php')($app);
    return $app;
};