<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Exception\FileReaderException;

class FileReader implements FileReaderInterface
{
    public function __construct(private string $file) {}

    public function read(): array
    {
        $result = [];

        if (!file_exists($this->file)) {
            throw new FileReaderException('Файл: ' . $this->file . ' не найден!');
        }

        try {
            $f = fopen($this->file,'r');
            while ($line = fgets($f)) {
                $result[] = json_decode($line, true);
            }
            fclose($f);

            return $result;
        } catch (\Exception $exception) {
            throw new FileReaderException('Ошибка чтения файла: ' . $this->file . '!' . $exception->getMessage());
        }
    }
}