<?php

declare(strict_types=1);

namespace Shilyaev\Mailchecker;

class App
{
    protected $file;
    protected array $emails;

    public function __construct()
    {
    }

    public function loadFromFile(?string $fileName) : void
    {
        if ($fileName!==NULL && strlen($fileName)>0)
        {
            if (file_exists($fileName))
            {
                if (!$this->file = fopen($fileName, 'r'))
                {
                    throw new \Exception('Не могу открыть входной файл.');
                }
            }
            else {
                throw new \Exception('Входной файл не существует.');
            }
        }
        else {
            throw new \Exception('Не указан входной файл.');
        }

        while (($line = fgets($this->file, 4096)) !== false) {
            $this->emails[]=$line;
        }

        fclose($this->file);
    }

    public function loadFromString(?string $string) : void
    {
        $stringArray = [];
        if ($strin!==NULL && strlen($string)>0)
        {
            $stringArray = explode(PHP_EOL, $string);
            foreach ($stringArray as $line)
               $this->emails[]=trim($line);
        }
        else {
            throw new \Exception('Не переданы данные для анализа.');
        }
    }

    public function run(bool $isCliMode = true) : string
    {
        $ValidEmails = [];
        $checker = new CheckEmail();

        foreach($this->emails as $email)
            if ($checker->check($email))
                $ValidEmails[]=$email;

        if (empty($ValidEmails))
            throw new \Exception('Не найдено валидных адресов.');

        if ($isCliMode)
            return implode(PHP_EOL,$ValidEmails);
        else
            return json_encode($ValidEmails);
    }
}