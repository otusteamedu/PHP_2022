<?php
require_once '../vendor/autoload.php';

use Larisadebelova\App\Validation;

try {
    $result = Validation::validate($_POST['string']);
    http_response_code(200);
    echo $result;
} catch (Exception $e) {
    http_response_code(400);
    echo $e->getMessage();
}


echo "\nТекущий контейнер nginx: " . $_SERVER['HOSTNAME'];

