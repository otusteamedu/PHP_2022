<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

class Agreement
{
    /**
     * Участники заявки.
     */
    public ParticipantList $ParticipantList;

    public function __construct(ParticipantList $ParticipantList)
    {
        $this->ParticipantList = $ParticipantList;
    }
}
