<?php

namespace Ilisitsa\Hw4;

use IvanLisitsa\TestPackage\TestService;

class StartService
{
    public function run()
    {
        $testService = new TestService();
        echo $testService->run(string: 'text');
    }
}

require __DIR__ . '/../vendor/autoload.php';

$startService = new StartService();
$startService->run();