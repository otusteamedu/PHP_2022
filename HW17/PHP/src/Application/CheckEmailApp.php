<?php

declare(strict_types = 1);

namespace App\Application;

use App\Domain\Model;
use App\Domain\Model\EmailContactsList;
use App\Domain\ValueObjects\Email;
use App\Application\Utils;
use App\Application\Contracts;

class CheckEmailApp
{

    protected Contracts\UploadEmailContactsInterface $uploadService;
    protected Model\EmailContactsList $validContactsList;
    protected Contracts\ResultInterface $result;

    public function __construct(Contracts\UploadEmailContactsInterface $uploadService, Contracts\ResultInterface $result)
    {
        $this->uploadService=$uploadService;
        $this->result=$result;
        $this->validContactsList=new \App\Domain\Model\EmailContactsList();
    }

    public function checkEmails(Utils\CheckEmail $emailChecker) : void
    {
        $contactListSource = $this->uploadService->getContacts();

        foreach ($contactListSource as $email)
        {

            if ($emailChecker->check($email->getEmailContact()->getValue()))
            {
                $this->validContactsList->add(new Model\EmailContact(new Email($email->getEmailContact()->getValue()), new \App\Domain\ValueObjects\Status(\App\Domain\ValueObjects\Status::ACTIVE)));
            }
        }
    }

    public function printResult() : void
    {
        $this->result->printResult($this->validContactsList);
    }

    public function getValidContactsList(): Model\EmailContactsList
    {
        return $this->validContactsList;
    }
}