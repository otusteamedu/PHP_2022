<?php
require_once __DIR__ . "./../vendor/autoload.php";

use Ppro\Hw28\Application\App;
use Ppro\Hw28\Exception\AppException;

try {
    $app = new App();
    $app->run();
}
catch (AppException $e) {
    echo 'Сервис временно недоступен';
}
catch(\Exception $e){
    echo $e->getMessage();
}