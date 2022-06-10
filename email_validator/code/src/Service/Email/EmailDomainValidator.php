<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email;


class EmailDomainValidator
{
    const EMAIL_DELIMITER = '@';


    private array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }


    public function getValidDomains()
    {
        $validDomains = [];
        foreach ($this->emails as $validEmailName) {
            $validDomains[] = $this->getDomainFromEmail($validEmailName);
        }
        $validDomains = array_unique($validDomains);
        return $validDomains;

    }

    public function getDomainFromEmail(string $validEmailName): ?string
    {
        return array_pop(explode(self::EMAIL_DELIMITER, $validEmailName));
    }
}