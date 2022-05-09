<?php

namespace App\FileManager;

class FileManager
{
    
    /**
     * open
     *
     * @param  mixed $path
     * @param  mixed $mode
     * @return File
     */
    public function open(string $path, string $mode): File
    {
        return new File($path, $mode);
    }

    
    /**
     * createOrOpen
     *
     * @param  mixed $path
     * @param  mixed $mode
     * @return File
     */
    public function createOrOpen(string $path, string $mode): File
    {
        if (!file_exists($path)) {
            touch($path);
        }

        return $this->open($path, $mode);
    }
}