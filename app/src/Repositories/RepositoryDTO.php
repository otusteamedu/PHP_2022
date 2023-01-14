<?php

declare(strict_types=1);

namespace App\Src\Repositories;

final class RepositoryDTO
{
    public string $key;
    public int $score;
    public string $conditions;
    public string $event_description;

    /**
     * @param string $key
     * @param int $score
     * @param string $conditions
     * @param string $event_description
     */
    public function __construct(string $key = '', int $score = 0, string $conditions = '', string $event_description = '')
    {
        $this->key = $key;
        $this->score = $score;
        $this->conditions = $conditions;
        $this->event_description = $event_description;
    }
}
