<?php

declare(strict_types=1);

namespace App\Config;

use RuntimeException;

class Configurator
{
    public string $config_file;

    public function __construct(string $config_file)
    {
        $this->config_file = $config_file;
        if (!is_file($config_file)) {
            throw new RuntimeException('Нет конфигурационного файла');
        }
    }

    public function getOptions(): array
    {
        $options = parse_ini_file($this->config_file, true);

        if ($options === false) {
            throw new RuntimeException('Конфигурационный файл поврежден');
        }

        return $options;
    }

}