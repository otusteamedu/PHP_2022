<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Services\MailValidator\ValidatorElements;

use Nsavelev\Hw5\Services\MailValidator\Interfaces\MailValidatorInterface;

class DnsMxMailValidator implements MailValidatorInterface
{
    /** @var array */
    private array $validEmails = [];

    /**
     * @param array $mails
     * @return array
     */
    public function validate(array $mails): array
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