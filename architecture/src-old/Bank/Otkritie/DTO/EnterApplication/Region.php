<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class Region
{
    /**
     * Название региона.
     */
    public string $content;

    /**
     * Код региона.
     */
    public int $code;

    /**
     * Тип региона (область, край и т.д.).
     */
    public string $type;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
}
