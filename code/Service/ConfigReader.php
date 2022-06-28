<?php

declare(strict_types=1);

namespace App\Service;

use RuntimeException;

class ConfigReader
{
    public function __construct(public string $config_file)
    {
        if (!is_file($config_file)) {
            throw new RuntimeException('No config file provided with '.$this->config_file);
        }
    }

    public function getOptions(): array
    {
        $options = parse_ini_file($this->config_file, true);

        if ($options === false) {
            throw new RuntimeException('An error occurred while processing '.$this->config_file);
        }

        return $options;
    }
}