<?php

namespace Service;

use Exception\FileNotFoundException;

class GetConfigDataService
{
    public function get(string $fileName): array
    {
        $filePath = getcwd() . '/config/' . $fileName . '.json';
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("There is no $fileName." . PHP_EOL);
        }

        $json = file_get_contents($filePath);
        return json_decode($json, flags:JSON_THROW_ON_ERROR);
    }
}
