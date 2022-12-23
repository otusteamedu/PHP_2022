<?php

declare(strict_types=1);

namespace Src\Domain\Contracts;

interface EmailHostnameExtractorContract
{
    /**
     * @param string $email
     * @return string
     */
    public function getHostname(string $email): string;
}
