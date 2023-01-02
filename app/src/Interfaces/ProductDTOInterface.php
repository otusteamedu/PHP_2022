<?php

declare(strict_types=1);

namespace HW10\App\Interfaces;

interface ProductDTOInterface
{
    public function getSku(): string;

    public function getTitle(): string;

    public function getCategory(): string;

    public function getPrice(): int;

    public function getData(): array;

    public function getStores(): array;
}
