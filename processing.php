<?php

declare(strict_types=1);

require("./vendor/autoload.php");

use Symfony\Component\HttpFoundation\Request;
use Mselyatin\Queue\infrastructure\jobs\QueueBankDetailsJob;

$configs = require_once('config/configs.php') ?? [];

try {
    $application = new \Mselyatin\Queue\Application();
    $application->run($configs);

    $request = new Request($_GET);
    $blankBtn = $request->get('blank_btn');
    $text = $request->get('text');

    if ($blankBtn && $text) {
        $queueManager = $application::$app->getQueueManager();
        $job = new QueueBankDetailsJob(
            [
                'text' => $text
            ]
        );
        $jobId = $queueManager->push($job, 'app');
        if ($jobId) {
            var_dump('Success');
        } else {
            var_dump('Unknown error!');
        }
    }
} catch (\Exception $e) {
    var_dump(
        'Unknown error. Retry later. ' . $e->getMessage()
    );
    die();
}