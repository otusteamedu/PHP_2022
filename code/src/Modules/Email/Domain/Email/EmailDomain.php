<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Domain\Email;

use Nikcrazy37\Hw13\Modules\Email\Domain\Exception\EmailDomainValidateException;

class EmailDomain
{
    private string $value;

    /**
     * @param string $value
     * @throws EmailDomainValidateException
     */
    public function __construct(string $value)
    {
        if (!checkdnsrr(trim($value))) {
            throw new EmailDomainValidateException();
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}