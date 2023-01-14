<?php

declare(strict_types=1);

namespace App\Factory;

use App\Application;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

class AppFactory
{
    public static function create(): Application
    {
        $aggregator = new ConfigAggregator([
            new PhpFileProvider(__DIR__ . '/../../config/*.php'),
        ]);
        return new Application($aggregator->getMergedConfig());
    }
}