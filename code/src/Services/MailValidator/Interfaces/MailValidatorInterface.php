<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Services\MailValidator\Interfaces;

interface MailValidatorInterface
{
    /**
     * @param array<string> $mails
     * @return mixed
     */
    public function validate(array $mails): array;
}