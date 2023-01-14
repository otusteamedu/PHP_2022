<?php

declare(strict_types=1);

namespace App\Src\Event;

use App\Src\Repositories\RepositoryDTO;

final class Event
{
    private string $key;
    private int $score;
    private string $conditions;
    private string $event_description;

    /**
     * @param RepositoryDTO $repository_dto
     */
    public function __construct(RepositoryDTO $repository_dto)
    {
        $this->key = $repository_dto->key;
        $this->score = $repository_dto->score;
        $this->conditions = $repository_dto->conditions;
        $this->event_description = $repository_dto->event_description;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getEventData(): string
    {
        return json_encode(value: [
            'conditions' => $this->conditions,
            'event' => $this->event_description,
        ]);
    }

    /**
     * @return string
     */
    public function getEventDataForMemcached(): string
    {
        return json_encode(value: [
            'score' => $this->score,
            'conditions' => $this->conditions,
            'event' => $this->event_description,
        ]);
    }

    public function getConditions(): string
    {
        return json_encode(value: ['conditions' => $this->conditions]);
    }
}
