<?php

declare(strict_types=1);

use Application\App;
use Infrastructure\Controllers\CliParser;
use Infrastructure\Repository\Search;
use Infrastructure\Views\Printer;

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$app = new App(new CliParser(), new Search(), new Printer());

try {
    $app->run();
} catch (Throwable $exception)
{
    echo "Error:".$exception->getMessage();
}