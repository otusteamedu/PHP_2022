<?php
declare(strict_types=1);

use Ilia\Otus\BracketValidation;

require_once __DIR__ . '/vendor/autoload.php';
$validator = new BracketValidation();
$validator->run($_POST['string']);


