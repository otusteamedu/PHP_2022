<?php

namespace KonstantinDmitrienko\App\Interfaces;

interface StorageInterface
{
    public function search(array $request): array;

    public function getAll(): array;

    public function add($data): array;

    public function delete(string $channelId): void;

    public function populate(): void;

    public function clear(): void;
}
