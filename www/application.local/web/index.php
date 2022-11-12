<?php
require __DIR__.'/../vendor/autoload.php';

use app\helpers\BracketsHelper;
use app\helpers\RequestHelper;

$requestHelper = new RequestHelper();
$requestHelper->setAllowedMethods(['POST']);

try {
    $requestHelper->checkActualMethod();
    $str = $requestHelper->getPostParamValue('string');

    $bracketsHelper = new BracketsHelper($str);
    $bracketsHelper->validateString();

    echo 'Скобки расставлены корректно.';

} catch (Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
}


