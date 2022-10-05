<?php

declare(strict_types=1);

defined('PUBLIC_PATH') || define('PUBLIC_PATH', __DIR__);
defined('BASE_PATH') || define('BASE_PATH', dirname(PUBLIC_PATH).'/');
defined('APP_PATH') || define('APP_PATH', realpath(BASE_PATH.'/code'));

use App\App;

require_once dirname(__DIR__).'/vendor/autoload.php';

try {
    $application = new App();
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage()."\n"."Trace: ".$e->getTraceAsString()."\n";
}