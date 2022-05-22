<?php

declare(strict_types=1);

namespace App;

use App\Service\PostProcessor;
use App\Service\InstanceChecker;

class App
{
    public static function run(): string
    {
        InstanceChecker::addHeader();

        return PostProcessor::process();
    }
}
