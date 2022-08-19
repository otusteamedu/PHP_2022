<?php
require_once __DIR__ . '/../backend/vendor/autoload.php';

use Api\Router;
use Api\ApiException;

try {
    $api = (new Router())->getApi();
    $api->respond();
} catch (ApiException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
}
