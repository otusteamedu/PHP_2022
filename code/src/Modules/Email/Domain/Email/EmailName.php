<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Domain\Email;

use Nikcrazy37\Hw13\Modules\Email\Domain\Exception\EmailNameValidateException;

class EmailName
{
    private string $value;

    /**
     * @param string $value
     * @throws EmailNameValidateException
     */
    public function __construct(string $value)
    {
        if (!filter_var(trim($value), FILTER_VALIDATE_EMAIL)) {
            throw new EmailNameValidateException();
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