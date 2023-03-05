<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

/**
 * Участники заявки.
 */
class ParticipantList
{
    /**
     * Участник заявки.
     *
     * @var Party|Party[]
     */
    public Party|array $Party;

    /**
     * @param Party|Party[] $Party
     */
    public function __construct(Party|array $Party)
    {
        $this->Party = $Party;
    }
}
