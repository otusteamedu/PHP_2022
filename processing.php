<?php

declare(strict_types=1);

require("./vendor/autoload.php");

use Symfony\Component\HttpFoundation\Request;
use Mselyatin\Queue\infrastructure\jobs\QueueBankDetailsJob;

$configs = require_once('config/configs.php') ?? [];

try {
    $application = new \Mselyatin\Queue\Application();
    $application->run($configs);
    $application->runFormProcessController();
} catch (\Exception $e) {
    var_dump(
        'Unknown error. Retry later. ' . $e->getMessage()
    );
    die();
}