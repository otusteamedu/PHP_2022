<?php

define('DEBUG', true);
define('APP_PATH', dirname(__DIR__));

/**
 * @param DEBUG
 */

require (__DIR__.'/../config/d_error.php');

/**
 *
 * helper functions
 */
require(__DIR__ . '/../Core/Init/helpers.php');
/**
 *
 * require autoload
 */
require(__DIR__ . '/../vendor/autoload.php');
$config = require(__DIR__ . '/../config/config.php');

try {
    (new App\Application($config))->run();
}catch (Core\Exceptions\InvalidApplicationConfig $e){
    echo($e->getMessage());
}
exit();