<?php
declare(strict_types=1);

use Igor\Hw4\BracketValidation;

require_once __DIR__ . '/../vendor/autoload.php';
$validator = new BracketValidation();
$validator->run();