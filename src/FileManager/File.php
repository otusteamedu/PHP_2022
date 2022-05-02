<?php

namespace App\FileManager;

class File
{

    private $file;

    public function __construct(string $path, string $mode)
    {
        if (!file_exists($path)) {
            throw new \Exception('file not found');
        }

        $file = fopen($path, $mode);

        if (!$file) {
            throw new \Exception('can not open input file');
        }

        $this->file = $file;
    }


    public function getNextLine()
    {
        return fgets($this->file);
    }


    public function putLine(string $line)
    {
        fwrite($this->file, $line . PHP_EOL);
    }


    public function rewind()
    {
        rewind($this->file);
    }


    public function isEndOfFile(): bool
    {
        return feof($this->file);
    }


    public function every(callable $callback)
    {
        $this->rewind();

        while (!$this->isEndOfFile()) {
            $line = trim($this->getNextLine());

            if ($line !== '') {
                $callback($line);
            }
        }
    }

    public function close()
    {
        fclose($this->file);
    }
}
