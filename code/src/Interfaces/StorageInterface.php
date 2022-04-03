<?php

namespace KonstantinDmitrienko\App\Interfaces;

interface StorageInterface
{
    public function search(array $params): array;

    public function add($data): array;

    public function delete(string $index, string $id): array;
}
