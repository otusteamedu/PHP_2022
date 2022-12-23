<?php

declare(strict_types=1);

namespace Src\Application\Services;

use Src\Domain\Contracts\EmailHostnameExtractorContract;

final class EmailHostnameExtractor implements EmailHostnameExtractorContract
{
    /**
     * @param string $email
     * @return string
     */
    public function getHostname(string $email): string
    {
        if (stristr(haystack: $email, needle: '@') === false) {
            return $email;
        }

        $email_parts = explode(separator: '@', string: $email);

        return $email_parts[1] ?? $email;
    }
}
