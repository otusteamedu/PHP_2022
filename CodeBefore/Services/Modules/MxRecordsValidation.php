<?php

declare(strict_types=1);

namespace Src\Services\Modules;

use Src\Services\Modules\Contracts\Validator;
use Src\Services\AdditionalServices\EmailHostnameExtractor;

final class MxRecordsValidation implements Validator
{
    /**
     * @param string $email
     * @return string
     */
    public function validate(string $email): string
    {
        $mx_record = getmxrr(hostname: $this->getHostname(email: $email), hosts: $hosts, weights: $weights);

        if (! $mx_record) {
            return 'mx_record_errors';
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param string $email
     * @return string
     */
    private function getHostname(string $email): string
    {
        $email_hostname_extractor = new EmailHostnameExtractor(email: $email);
        return $email_hostname_extractor->getHostname();
    }
}
