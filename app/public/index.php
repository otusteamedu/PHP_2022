<?php
require_once '../vendor/autoload.php';

use Larisadebelova\App\Validation;

Validation::run($_POST['string']);

echo "\nТекущий контейнер nginx: " . $_SERVER['HOSTNAME'];

