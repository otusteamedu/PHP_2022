<?php

declare(strict_types=1);

namespace App;

use App\Service\ConfigReader;
use App\Service\Event\EventManager;
use App\Service\PostProcessor;
use App\Service\Storage\RedisStorage;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    public function __construct()
    {
        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    public function run(): string
    {
        $storage = new RedisStorage([
            'host' => $this->options['redis']['host'],
        ]);

        $em = new EventManager($storage);

        $processor = new PostProcessor($em);

        return $processor->process()->send();
    }
}