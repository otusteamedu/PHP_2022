<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class Country
{
    /**
     * Название страны.
     */
    public string $content;

    /**
     * Код страны.
     */
    public string $code;

    public function __construct(string $code, string $content)
    {
        $this->code = $code;
        $this->content = $content;
    }
}
