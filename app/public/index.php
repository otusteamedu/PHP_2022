<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HW10\App\SearchProductQuery;
use HW10\App\DTO\BookProductDTO;
use HW10\App\ProductsOutput;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    $app = new \HW10\App\App(ProductsOutput::class);
    $app->run(SearchProductQuery::class, BookProductDTO::class);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
