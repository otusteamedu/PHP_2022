<?php
declare(strict_types=1);

namespace Otus\Task06\App\Services;

class EmailReaderService
{

    public function __construct(private string $file){

        if(!is_file($this->file)){
            throw new \LogicException('Файл с почтовыми адресами не существует');
        }
        if(!is_readable($this->file)){
            throw new \LogicException('Файл с почтовыми адресами не доступе для чтения');
        }
    }

    public function getEmails(): array
    {
        return array_map('trim', file($this->file));
    }


}