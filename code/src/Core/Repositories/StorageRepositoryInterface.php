<?php

namespace Decole\Hw13\Core\Repositories;

use Decole\Hw13\Core\Dtos\EventAddDto;

interface StorageRepositoryInterface
{
    public function save(EventAddDto $dto): void;

    public function getByParams(array $condition): array;

    public function deleteAll(): void;
}