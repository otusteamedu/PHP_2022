<?php

declare(strict_types = 1);

namespace App\Domain\Model;

class EmailContact
{
    protected \App\Domain\ValueObjects\Email $email;
    protected \App\Domain\ValueObjects\Status $status;


    public function __construct(\App\Domain\ValueObjects\Email $email, \App\Domain\ValueObjects\Status $status)
    {
        $this->email = $email;
        $this->status = $status;
    }

    /**
     * @return Email
     */
    public function getEmailContact(): \App\Domain\ValueObjects\Email
    {
        return $this->email;
    }

    /**
     * @return Status
     */
    public function getStatus(): \App\Domain\ValueObjects\Status
    {
        return $this->status;
    }




}