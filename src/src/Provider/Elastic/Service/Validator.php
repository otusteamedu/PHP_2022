<?php

namespace App\Provider\Elastic\Service;

use RuntimeException;

class Validator
{
    public static function validateFilePath(string $path): string
    {
        if (!file_exists($path)) {
            throw new RuntimeException("File does not exist");
        }
        return $path;
    }

    public static function validateString(string $str): string
    {
        if (empty($str)) {
            throw new RuntimeException("An empty string was passed");
        }
        return $str;
    }
}