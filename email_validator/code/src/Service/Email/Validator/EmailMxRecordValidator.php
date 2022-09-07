<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email\Validator;

use Mapaxa\EmailVerificationApp\Service\Email\EmailValidatorInterface;

class EmailMxRecordValidator implements EmailValidatorInterface
{
    const EMAIL_DELIMITER = '@';

    public function validate(array $emails): ?array
    {
        $domains = $this->getDomainFromEmails($emails);
        $validDomains = $this->getDomainsWithExistingMxRecords($domains);

        $validEmails = $this->getValidNamesWithExistingMxRecords($validDomains, $emails);

        return $validEmails;
    }

    private function getDomainFromEmails(array $emails): ?array
    {
        $validDomains = [];
        foreach ($emails as $validEmailName) {
            $validDomains[] = array_pop(explode(self::EMAIL_DELIMITER, $validEmailName));
        }
        return array_unique($validDomains);
    }

    private function getDomainsWithExistingMxRecords(array $domains): array
    {
        return array_filter($domains, function($validDomain) {
            return getmxrr($validDomain, $mxhosts);
        });
    }

    private function getValidNamesWithExistingMxRecords(array $domainsWithExistingMxRecords, array $validEmailNames): ?array
    {
        $validAndExistingDomains = [];

        foreach ($domainsWithExistingMxRecords as $domainWithExistingMxRecords) {
            foreach ($validEmailNames as $validEmailName) {
                if (stristr($validEmailName, self::EMAIL_DELIMITER.$domainWithExistingMxRecords) == true) {
                    $validAndExistingDomains[] = $validEmailName;
                }
            }
        }
        return $validAndExistingDomains;
    }
}