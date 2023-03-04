<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Address;

/**
 * Информация об улице.
 */
class Street
{
    /**
     * Название улицы.
     */
    public string $content;

    /**
     * Тип улицы.
     */
    public string $type;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
}
