<?php

namespace ValueObject;

use Dto\ElasticConfigDto;
use Exception\FileNotFoundException;

class Config
{
    /**
     * @return ElasticConfigDto
     * @throws FileNotFoundException
     */
    public function getConfig(): ElasticConfigDto
    {
        $file = parse_ini_file(getcwd() . '/config/' . ConfigFileName::CONFIG_FILENAME);

        if (!$file) {
            throw new FileNotFoundException("Config file " . ConfigFileName::CONFIG_FILENAME . " not found.");
        }

        return new ElasticConfigDto(
            $file[ConfigKey::HOST],
            $file[ConfigKey::INDEX]
        );
    }
}
