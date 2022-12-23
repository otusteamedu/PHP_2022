<?php

declare(strict_types=1);

namespace Src\Services\AdditionalServices;

final class EmailHostnameExtractor
{
    private string $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        if (stristr(haystack: $this->email, needle: '@') === false) {
            return $this->email;
        }

        $email_parts = explode(separator: '@', string: $this->email);

        return $email_parts[1] ?? $this->email;
    }
}
