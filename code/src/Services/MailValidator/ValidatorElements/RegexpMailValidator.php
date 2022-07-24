<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Services\MailValidator\ValidatorElements;

use Nsavelev\Hw5\Services\MailValidator\Interfaces\MailValidatorInterface;

class RegexpMailValidator implements MailValidatorInterface
{
    /** @var string */
    private $emailPattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';

    /**
     * @param array $mails
     * @return array
     */
    public function validate(array $mails): array
    {
        $validatedMails = array_filter($mails, function ($mail) {
            $isMailValid = preg_match($this->emailPattern, $mail);

            return $isMailValid;
        });

        return $validatedMails;
    }
}