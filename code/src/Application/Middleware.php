<?php
declare(strict_types=1);

use Slim\App;

use adrianfalleiro\SlimCliRunner\CliRunner;

return function (App $app) {
    $app->add(CliRunner::class);
};
