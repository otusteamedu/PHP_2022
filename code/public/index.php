<?php

define('DEBUG', true);
define('APP_PATH', dirname(__DIR__));

/**
 * @param DEBUG
 */

require (__DIR__.'/../config/d_error.php');

/**
 *
 * require autoload
 */
require(__DIR__ . '/../vendor/autoload.php');

try {
    (new App\Application())->run();
}catch (\Exception $e){
    echo($e->getMessage());
}
exit();