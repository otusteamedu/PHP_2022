<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Configuration;
use Nikolai\Php\ControllerResolver\ConsoleCommandControllerResolver;

class Application implements ApplicationInterface
{
    const CONFIGURATION_FILE = '/config/services.yaml';

    public function run(): void
    {
        $configurationLoader = new Configuration\ConfigurationLoader(
            dirname(__DIR__) . self::CONFIGURATION_FILE
        );
        $configuration = $configurationLoader->load();

        $controller = (new ConsoleCommandControllerResolver($_SERVER['argv'][1]))->resolve();
        $controller($configuration['parameters']['socketFile']);
    }
}