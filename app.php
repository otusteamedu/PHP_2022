<?php

declare(strict_types=1);

defined('BASE_PATH') || define('BASE_PATH', __DIR__);
defined('APP_PATH') || define('APP_PATH', realpath(BASE_PATH.'/code'));

use App\App;

require_once 'vendor/autoload.php';

try {
    $application = new App(
        getopt("", [
            "title::",
            "sku::",
            "category::",
            "in_stock",
            "price_from::",
            "price_to::",
            "limit::",
            "offset::",
        ])
    );
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage()."\n"."Trace: ".$e->getTraceAsString()."\n";
}
