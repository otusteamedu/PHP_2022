#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Infrastructure\Cli\CliDialog;

require_once __DIR__ . '/vendor/autoload.php';

$cli_dialog = new CliDialog();

try {
    $cli_dialog->startDialog();
} catch (\Throwable $exception) {
    fwrite(stream: STDOUT ,data: $exception->getMessage() . PHP_EOL);
}