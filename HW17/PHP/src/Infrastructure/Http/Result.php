<?php

declare(strict_types = 1);

namespace App\Infrastructure\Http;

use App\Application;
use App\Application\Contracts;
use App\Domain\Model\EmailContact;

class Result implements \App\Application\Contracts\ResultInterface
{

    public function printResult($validEmailList) : void
    {
        $email = [];
        foreach ($this->validContactsList as $emailContact)
        {
            $email[]=$emailContact->getEmailContact()->getValue();
        }
        http_response_code(400);
        json_encode($email);
    }
}