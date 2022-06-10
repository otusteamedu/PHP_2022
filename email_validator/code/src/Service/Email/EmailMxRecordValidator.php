<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email;


class EmailMxRecordValidator
{
    private array $emails;




    public function getDomainsWithExistingMxRecords(array $validDomains): array
    {
        return array_filter($validDomains, function($validDomain) {
            return getmxrr($validDomain, $mxhosts);
        });
    }
}