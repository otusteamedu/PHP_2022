<?php

namespace Service;

use Exception\FileNotFoundException;

class GetEmailsService
{
    public function get(): array
    {
        $filePath = getcwd() . '/config/config.json';
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("There is no $filePath." . PHP_EOL);
        }

        $json = file_get_contents($filePath);
        return json_decode($json, flags:JSON_THROW_ON_ERROR);
    }
}
