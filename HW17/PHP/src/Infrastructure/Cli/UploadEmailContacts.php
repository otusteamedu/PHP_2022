<?php

declare(strict_types = 1);

namespace App\Infrastructure\Cli;

use App\Application;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Status;
use App\Domain\Model\EmailContact;
use App\Domain\Model\EmailContactsList;


class UploadEmailContacts implements \App\Application\Contracts\UploadEmailContactsInterface
{
    protected string $source_file;

    public function __construct(string $filename)
    {
        $this->source_file = $filename;
    }

    /**
     * @throws \Exception
     */
    public function getContacts() : EmailContactsList
    {
        // TODO: Implement getContacts() method.
        $contactsList = new EmailContactsList();

        if (file_exists($this->source_file))
        {
            if (!$file = fopen($this->source_file, 'r'))
            {
                throw new \Exception('Не могу открыть входной файл.');
            }
            while (($line = fgets($file, 4096)) !== false) {
                try {
                    $contactsList->add(new EmailContact(new \App\Domain\ValueObjects\Email($line), new Status(Status::UNKNOWN)));
                } catch (\InvalidArgumentException $e) {};
            }
            fclose($file);
        }
        else
        {
            throw new \Exception('Входной файл не существует.');
        }

        return $contactsList;
    }
}