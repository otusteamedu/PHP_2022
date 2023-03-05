<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class Citizenship
{
    public string $content;
    public string $countryCode;

    public function __construct(string $content, string $countryCode)
    {
        $this->content = $content;
        $this->countryCode = $countryCode;
    }
}
