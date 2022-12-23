<?php

declare(strict_types=1);

namespace Src\Domain\UseCases;

use Src\Application\Exceptions\MxRecordsValidationException;

final class MxRecordsValidation
{
    /**
     * @param string $email_hostname
     * @return void
     * @throws MxRecordsValidationException
     */
    public function validate(string $email_hostname): void
    {
        $mx_record = getmxrr(hostname: $email_hostname, hosts: $hosts);

        if (! $mx_record) {
            throw new MxRecordsValidationException(message: 'mx_record_errors');
        }
    }
}
