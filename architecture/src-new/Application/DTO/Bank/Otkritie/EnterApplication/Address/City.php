<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Address;

class City
{
    public string $content;

    public string $code;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
}
