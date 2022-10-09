<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\config;

use Nemizar\OtusShop\exception\FileNotFoundException;

class ConfigLoader
{
    private string $configFile = __DIR__ . '/config.ini';

    public function __invoke(): Config
    {
        if (!\file_exists($this->configFile)) {
            throw new FileNotFoundException('Файл конфигурации не найден');
        }

        $options = \parse_ini_file($this->configFile, true);

        return new Config($options['host'], $options['index']);
    }
}
