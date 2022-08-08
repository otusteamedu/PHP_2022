<?php

declare(strict_types = 1);

namespace App\Application\Contracts;

use App\Domain\Model\EmailContact;
use App\Domain\Model\EmailContactsList;

interface UploadEmailContactsInterface
{
    public function getContacts() : EmailContactsList;
}