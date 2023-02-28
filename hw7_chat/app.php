<?php

/**
 * Client app/code
 * Starting client/serber apps from here
 *
 * Run samples:
 * php app.php server
 * php app.php client
 */

declare(strict_types=1);

use App\App;

require_once 'vendor/autoload.php';

try {
    $application = new App($argv, __DIR__);
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage()."\n"."Trace: ".$e->getTraceAsString()."\n";
}