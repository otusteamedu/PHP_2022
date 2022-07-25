<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Http\Controllers\CheckEmails;

use Nsavelev\Hw5\Foundation\Request\Exceptions\RequestDataIsEmptyException;
use Nsavelev\Hw5\Http\Requests\CheckEmails\CheckRequest;
use Nsavelev\Hw5\Http\Requests\CheckEmails\Exceptions\MailIsNotStringException;
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
     */
    public function check(): string
    {
        try {
            $request = new CheckRequest();

            $mails = $request->getMails();

            $validatedMails = $this->mailValidatorService->validate($mails);

            $encodedValidatedMails = json_encode($validatedMails, JSON_THROW_ON_ERROR);

            return $encodedValidatedMails;
        } catch (MailIsNotStringException|RequestDataIsEmptyException $exception) {
            http_response_code(400);

            return $exception->getMessage();
        } catch (\Exception $exception) {
            http_response_code(500);

            return $exception->getMessage();
        }
    }
}