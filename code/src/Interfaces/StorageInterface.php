<?php

namespace KonstantinDmitrienko\App\Interfaces;

interface StorageInterface
{
    public function search(array $data): array;

    public function getAll(): array;

    // public function get(string $channelId): ?YoutubeChannel;

    // public function create($channel): void;

    public function add($data): void;

    public function delete(string $channelId): void;

    public function populate(): void;

    public function clear(): void;
}
