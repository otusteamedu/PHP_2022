<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

/**
 * Список наименований чего-либо.
 */
class NameList
{
    /**
     * @var Name[]
     */
    public array $Name;

    /**
     * @param Name[] $Name
     */
    public function __construct(array $Name)
    {
        $this->Name = $Name;
    }
}
