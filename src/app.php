#!/usr/bin/env php
<?php

declare(strict_types=1);

use Src\Sandwich\Infrastructure\CliController;

require_once __DIR__ . '/../vendor/autoload.php';

$dialog = new CliController();

$product = $dialog->startCooking();

var_dump($product);
