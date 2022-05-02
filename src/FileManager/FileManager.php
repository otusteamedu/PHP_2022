<?php

namespace App\FileManager;

class FileManager
{

    public function open(string $path, string $mode): File
    {
        return new File($path, $mode);
    }


    public function createOrOpen(string $path, string $mode): File
    {
        if (!file_exists($path)) {
            touch($path);
        }

        return $this->open($path, $mode);
    }
}
