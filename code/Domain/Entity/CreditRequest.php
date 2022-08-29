<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class CreditRequest implements CreditRequestInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $passport_number,
        private readonly string $passport_who,
        private readonly string $passport_when
    ) {
    }

    public function send(): void
    {
        // make some API request;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassportNumber(): string
    {
        return $this->passport_number;
    }

    public function getPassportWho(): string
    {
        return $this->passport_who;
    }

    public function getPassportWhen(): string
    {
        return $this->passport_when;
    }
}