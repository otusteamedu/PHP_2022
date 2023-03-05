<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Список мест работы клиента.
 */
class WorkPlaceList
{
    /**
     * @var WorkPlace[]
     */
    public array $WorkPlace;

    public function __construct(array $WorkPlace)
    {
        $this->WorkPlace = $WorkPlace;
    }
}
