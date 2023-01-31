#!/usr/bin/env php
<?php

declare(strict_types=1);

use Src\Sandwich\Infrastructure\CliController;

require_once __DIR__ . '/../vendor/autoload.php';

$dialog = new CliController();

try {
    $product = $dialog->startCooking();

    if (empty($product->ingredients)) {
        return;
    }

    echo 'Изготовлен ' . $product . ' со следующими ингридиентами : '
        . implode(separator: ', ', array: $product->ingredients) . PHP_EOL;
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
