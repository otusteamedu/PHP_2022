<?php

declare(strict_types = 1);

namespace App\Infrastructure\Http;

use App\Application;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Status;
use App\Domain\Model\EmailContact;
use App\Domain\Model\EmailContactsList;

class UploadEmailContacts implements \App\Application\Contracts\UploadEmailContactsInterface
{
    protected string $jsonRequestString;

    /**
     * @param string $jsonRequestString
     */
    public function __construct(string $jsonRequestString)
    {
        $this->jsonRequestString = $jsonRequestString;
    }


    /**
     * @throws \Exception
     */
    public function getContacts() : EmailContactsList
    {
        $stringArray = [];
        $contactsList = new EmailContactsList();
        if ($this->jsonRequestString!==NULL && strlen($this->jsonRequestString)>0)
        {
            $stringArray = explode(PHP_EOL, $this->jsonRequestString);
            foreach ($stringArray as $line)
                try {
                    $contactsList->add(new EmailContact(new Email(trim($line)), new Status(Status::UNKNOWN)));
                 } catch (\InvalidArgumentException $e) {};
        }
        else {
            throw new \Exception('Не переданы данные для анализа.');
        }
        return $contactsList;
    }
}