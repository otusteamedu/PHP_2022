<?php

declare(strict_types = 1);

namespace App\Application\Service;

use App\Domain\Model\Email;
use App\Domain\Model\Status;
use App\Domain\Model\EmailContact;

class EmailContactService
{
    public function createEmailContact(string $email) : EmailContact
    {
        $email = new Email($email);
        $status = new Status(0);
        $contact = new EmailContact($email, $status);
        return $contact;
    }

}