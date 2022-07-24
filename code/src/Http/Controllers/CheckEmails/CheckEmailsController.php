<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Http\Controllers\CheckEmails;

use Nsavelev\Hw5\Http\Requests\CheckEmails\CheckRequest;
use Nsavelev\Hw5\Services\MailValidator\Interfaces\MailValidatorInterface;
use Nsavelev\Hw5\Services\MailValidator\MailValidatorService;

class CheckEmailsController
{
    /** @var MailValidatorService */
    private MailValidatorInterface $mailValidatorService;

    public function __construct()
    {
        $this->mailValidatorService = new MailValidatorService();
    }

    /**
     * @return string
     * @throws \JsonException
     */
    public function check(): string
    {
        $request = new CheckRequest();

        $mails = $request->getMails();

        $validatedMails = $this->mailValidatorService->validate($mails);

        $encodedValidatedMails = json_encode($validatedMails, JSON_THROW_ON_ERROR);

        return $encodedValidatedMails;
    }
}