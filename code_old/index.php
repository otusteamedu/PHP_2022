<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Kogarkov\Es\App\App;
use Kogarkov\Es\Core\Service\Response;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    $response = new Response();
    $response->setData(['message' => $e->getMessage()])->asJson()->isBad();
}
