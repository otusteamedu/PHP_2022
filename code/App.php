<?php

declare(strict_types=1);

namespace App;

use App\Service\{InstanceChecker, PostProcessor};

class App
{
    public function run(): string
    {
        InstanceChecker::addHeader();

        $postProcessor = new PostProcessor();

        return $postProcessor->process()->send();
    }
}
