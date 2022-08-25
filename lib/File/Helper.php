<?php

namespace Otus\File;

class Helper
{
    public $filePath = '';

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /** Чтение файла построчно
     * @return \Generator
     */
    function getRows()
    {
        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new Exception();
        }
        while (!feof($handle)) {
            yield fgets($handle);
        }
        fclose($handle);
    }
}