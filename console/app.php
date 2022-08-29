<?php
declare(strict_types=1);

require("./vendor/autoload.php");

use Mselyatin\Queue\infrastructure\controllers\console\QueueListenController;

$configs = require_once('config/configs.php') ?? [];
try {
    $application = new \Mselyatin\Queue\Application();
    $application->run($configs);

    $queueManager = $application::$app->getQueueManager();
    $queueManager->listen('app');
} catch (\Exception $e) {
    var_dump(
        'Unknown error. Retry later. ' . $e->getMessage()
    );
    die();
}