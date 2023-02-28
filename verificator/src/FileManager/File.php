<?php

namespace App\FileManager;

class File
{
    
    /**
     * file
     *
     * @var mixed
     */
    private $file;
    
    /**
     * __construct
     *
     * @param  mixed $path
     * @param  mixed $mode
     * @return void
     */
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

    
    /**
     * getNextLine
     *
     * @return string
     */
    public function getNextLine()
    {
        return fgets($this->file);
    }

    
    /**
     * putLine
     *
     * @param  mixed $line
     * @return void
     */
    public function putLine(string $line)
    {
        fwrite($this->file, $line . PHP_EOL);
    }

    
    /**
     * rewind
     *
     * @return void
     */
    public function rewind()
    {
        rewind($this->file);
    }

    
    /**
     * isEndOfFile
     *
     * @return bool
     */
    public function isEndOfFile(): bool
    {
        return feof($this->file);
    }   

    /**
     * every
     *
     * @param  mixed $callback
     * @return void
     */
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
    
    /**
     * close
     *
     * @return void
     */
    public function close()
    {
        fclose($this->file);
    }
}