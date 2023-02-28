<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Chat\Config;

use Nemizar\Php2022\Chat\Exception\FileNotFoundException;

class ConfigLoader
{
    private string $configFile = __DIR__ . '/config.ini';

    public function __invoke(): Config
    {
        if (!\file_exists($this->configFile)) {
            throw new FileNotFoundException('Файл конфигурации не найден');
        }

        $options = \parse_ini_file($this->configFile, true);

        return new Config($options['server_sock'], $options['client_sock']);
    }
}
