<?php

declare(strict_types = 1);

namespace App\Infrastructure\Cli;

use App\Application;
use App\Application\Contracts;
use App\Domain\Model\EmailContact;

class Result implements \App\Application\Contracts\ResultInterface
{
    public function printResult($validEmailList) : void
    {
        foreach ($validEmailList as $emailContact)
        {
            echo $emailContact->getEmailContact()->getValue().PHP_EOL;
        }
        exit(0);
    }
}