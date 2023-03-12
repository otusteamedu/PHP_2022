<?php
require_once __DIR__ . "./../vendor/autoload.php";

use Ppro\Hw27\App\Application\App;
use Ppro\Hw27\App\Exceptions\AppException;

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