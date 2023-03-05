<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Job;

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
