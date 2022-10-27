<?php

require_once '../vendor/autoload.php';

use ATolmachev\MyApp\App;
use ATolmachev\MyApp\Exceptions\AppException;

try {
    $app = new App($argv[1]);
    $app->run();
} catch (AppException $exception) {
    echo $exception->getMessage() . PHP_EOL;
} catch (\Exception) {
    echo 'Возникла внутренняя ошибка' . PHP_EOL;
}