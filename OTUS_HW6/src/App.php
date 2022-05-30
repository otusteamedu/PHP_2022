<?php

declare(strict_types=1);

namespace Shilyaev\Mailchecker;

class App
{
    protected $file;

    public function __construct()
    {
    }

    public function run()
    {
        global $argv;
        if (isset($argv[1]))
        {
            $filename = $argv[1];
            if (file_exists($filename))
            {
                if (!$this->file = fopen($filename, 'r'))
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

        $ValidEmails = "";
        $Checker = new CheckEmail();
        while (($line = fgets($this->file, 4096)) !== false) {
            if ($Checker->check($line))
            {
                $ValidEmails.=$line;
            }
        }

        fclose($this->file);

        if (strlen($ValidEmails)<=0)
            throw new \Exception('Не найдено валидных адресов.');

        return $ValidEmails;
    }
}