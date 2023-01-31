<?php

declare(strict_types=1);

use Src\Sandwich\Infrastructure\WebController;

require_once __DIR__ . '/../vendor/autoload.php';

$dialog = new WebController();

$product = $dialog->startCooking();

var_dump($product);
