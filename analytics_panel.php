#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Src\Infrastructure\Cli\CliDialog;

require_once __DIR__ . '/vendor/autoload.php';

$cli_dialog = new CliDialog();

$cli_dialog->startDialog();
