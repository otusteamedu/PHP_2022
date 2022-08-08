<?php

declare(strict_types = 1);

namespace App\Application\Contracts;

use App\Domain\Model\EmailContactsList;

interface ResultInterface
{
    public function printResult(EmailContactsList $validEmailList) : void;
}