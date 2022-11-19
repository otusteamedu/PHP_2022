<?php

declare(strict_types=1);

use App\Http\CheckBrackets;
use App\Http\CheckEmailsList;
use App\Http\HomePage;
use App\Http\SessionTest;
use Slim\App;

return static function (App $app): void {

    $app->get('/', HomePage::class);
    $app->get('/session-test', SessionTest::class);

    $app->post('/check-brackets', CheckBrackets::class);
    $app->post('/check-emails-list', CheckEmailsList::class);
};
