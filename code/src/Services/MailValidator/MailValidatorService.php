<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Services\MailValidator;

use Nsavelev\Hw5\Services\MailValidator\Interfaces\MailValidatorInterface;

class MailValidatorService implements MailValidatorInterface
{
    /** @var array */
    private $validEmails = [];

    /** @var string */
    private $emailPattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';

    /**
     * @inheritDoc
     */
    public function validate(array $mails): array
    {
        $validatedMails = $this->validateByRegExp($mails);

        if (!empty($validatedMails)) {
            $validatedMails = $this->validateByDns($validatedMails);
        }

        return $validatedMails;
    }

    /**
     * @param array $mails
     * @return array
     */
    private function validateByRegExp(array $mails): array
    {
        $validatedMails = array_filter($mails, function ($mail) {
            $isMailValid = preg_match($this->emailPattern, $mail);

            return $isMailValid;
        });

        return $validatedMails;
    }

    /**
     * @param array $mails
     * @return array
     */
    private function validateByDns(array $mails): array
    {
        $validatedMails = array_filter($mails, function ($mail) {
            $mailHostname = $this->getHostnameFromEmail($mail);

            if (in_array($mailHostname, $this->validEmails)) {
                return true;
            }

            $validatedMail = dns_check_record($mailHostname);

            if (!empty($validatedMail)) {
                $this->validEmails[] = $mailHostname;
            }

            return $validatedMail;
        });

        return $validatedMails;
    }

    /**
     * @param string $email
     * @return string
     */
    private function getHostnameFromEmail(string $email): string
    {
        $hostname = '';

        $splitEmail = explode('@', $email);

        if (is_array($splitEmail) && array_key_exists(1, $splitEmail)) {
            $hostname = $splitEmail[1];
        }

        return $hostname;
    }
}