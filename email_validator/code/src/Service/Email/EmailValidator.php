<?php
declare(strict_types=1);

namespace Mapaxa\EmailVerificationApp\Service\Email;


use Mapaxa\EmailVerificationApp\Dto\Email;

class EmailValidator {

    const EMAIL_DELIMITER = '@';

    private $emails;

    public function __construct(array $emails)
    {
        $this->emails = array_map(function($email) {
            return trim($email);
        }, $emails);
    }

    public function getValidEmails(): array
    {
        //валидные имена имэйлов
        $validEmailNames = array_filter($this->emails, function($email) {
            return $this->isValidEmailName($email);
        });

        //достаём домены
        $validDomains = [];
        foreach ($validEmailNames as $validEmailName) {
            $validDomains[] = $this->getDomainFromEmail($validEmailName);
        }

        $validDomains = array_unique($validDomains);

        $domainsWithExistingMxRecords = $this->getDomainsWithExistingMxRecords($validDomains);

        //валидные имэйлы с рабочими доменами
        $validAndExistingDomains = [];
        foreach ($domainsWithExistingMxRecords as $domainWithExistingMxRecords) {
            foreach ($validEmailNames as $validEmailName) {
                if ($this->getDomainFromEmail($validEmailName) == $domainWithExistingMxRecords) {
                    $validAndExistingDomains[] = new Email($validEmailName, $domainWithExistingMxRecords);
                }
            }
        }
        return $validAndExistingDomains;
    }


    private function isValidEmailName(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null ;
    }

    private function getDomainFromEmail(string $validEmailName): ?string
    {
        return array_pop(explode(self::EMAIL_DELIMITER, $validEmailName));
    }

    private function getDomainsWithExistingMxRecords(array $validDomains): array
    {
        return array_filter($validDomains, function($validDomain) {
            return getmxrr($validDomain, $mxhosts);
        });
    }

}

