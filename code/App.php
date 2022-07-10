<?php

declare(strict_types=1);

namespace App;

use App\Service\ConfigReader;
use App\Service\Event\EventManager;
use App\Service\PostProcessor;
use App\Service\Storage\StorageManager;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    private StorageManager $storageManager;

    public function __construct()
    {
        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();

        $this->storageManager = new StorageManager();
    }

    public function run(): string
    {
        $storage = $this->storageManager->getStorage($this->options);
        $em = new EventManager($storage);
        $processor = new PostProcessor($em);

        return $processor->process()->send();
    }
}