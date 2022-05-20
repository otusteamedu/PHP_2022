<?php

declare(strict_types=1);

namespace App\Application\Contract;

interface CreateRequestInterface
{
    public function getId(): ?string;

    public function getValue(): ?string;

    public function setId(string $id): static;

    public function setValue(string $string): static;
}