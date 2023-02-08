<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Map;

interface Entity
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): static;
}