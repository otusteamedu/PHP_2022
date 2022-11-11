<?php

declare(strict_types=1);

use App\Http\CheckBrackets;
use App\Http\HomePage;
use App\Http\SessionTest;
use Slim\Factory\AppFactory;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', HomePage::class);
$app->post('/', CheckBrackets::class);
$app->get('/session-test', SessionTest::class);

$app->run();