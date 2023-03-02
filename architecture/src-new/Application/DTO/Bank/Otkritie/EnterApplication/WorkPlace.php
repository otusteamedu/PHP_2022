<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

/**
 * Информация о месте работы.
 */
class WorkPlace
{
    public WorkInfo $WorkInfo;

    public PartyInfo $PartyInfo;

    public function __construct(WorkInfo $WorkInfo, PartyInfo $PartyInfo)
    {
        $this->WorkInfo = $WorkInfo;
        $this->PartyInfo = $PartyInfo;
    }
}
