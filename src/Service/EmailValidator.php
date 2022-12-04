<?php

namespace Octopus\Php2022\Service;

class EmailValidator
{
    private const EMAIL_REG = "/^[a-z_.0-9]+@[a-z]+\.[a-z]+/i";
    private const DNS_REG = "/(?<=@).+/i";
    private array $mails;
    private array $validMails;
    private array $invalidMails;

    public function __construct(array $mails)
    {
        $this->mails = $mails;
    }

    public function validate(): array
    {
        if (empty($this->mails)) {
            throw new \Exception('Mails empty');
        }

        foreach ($this->mails as $mail) {
            if ($this->isValid($mail)) {
                $this->validMails[] = $mail;
            } else {
                $this->invalidMails[] = $mail;
            }
        }

        return [
          'valid' => $this->validMails,
          'invalid' => $this->invalidMails
        ];
    }

    private function isValid(string $email): bool
    {
        return preg_match(self::EMAIL_REG, $email)
            && $this->isValidDNS($email);
    }

    private function isValidDNS(string $email): bool
    {
        preg_match(self::DNS_REG, $email, $match);

        return !empty($match) && checkdnsrr($match[0]);
    }
}
