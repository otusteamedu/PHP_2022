<?php

namespace Patterns\App\Domain\Entity;

interface Entity
{
    public function getId(): int;
    public function toArray(): array;
}