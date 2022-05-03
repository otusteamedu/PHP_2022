<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\services;

/**
 * @EmailValidationService
 * @\Mselyatin\Project6\src\services\EmailValidationService
 */
class EmailValidationService
{
    /** @var array  */
    private array $emails;

    /**
     * @param array $emails
     */
    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    /**
     * @param string $email
     */
    public function addEmail(string $email): void
    {
        $this->emails[] = $email;
    }

    /**
     * @return array
     */
    public function validation(): array
    {
        $result = [];
        foreach ($this->emails as $email) {
            $isValid = true;

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isValid = false;
            }

            if (!$this->emailDomainIsValid($email)) {
                $isValid = false;
            }

            $result[] = [
                'email' => $email,
                'isValid' => $isValid
            ];
        }

        return $result;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function emailDomainIsValid(string $email): bool
    {
        $domain = substr($email, (strpos($email, '@') + 1));
        return checkdnsrr($domain);
    }
}