<?php

declare(strict_types=1);

use Slim\App;
use Slim\Factory\AppFactory;

return static function (): App {
    http_response_code(500);
    $app = AppFactory::create();
    (require __DIR__ . '/routes.php')($app);
    return $app;
};