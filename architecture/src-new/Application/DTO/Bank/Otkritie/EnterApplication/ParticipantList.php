<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

/**
 * Участники заявки.
 */
class ParticipantList
{
    /**
     * Участник заявки.
     *
     * @var Party[]
     */
    public array $Party;

    /**
     * @param Party[] $Party
     */
    public function __construct(array $Party)
    {
        $this->Party = $Party;
    }
}
