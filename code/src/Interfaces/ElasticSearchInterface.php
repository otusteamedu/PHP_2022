<?php

namespace KonstantinDmitrienko\App\Interfaces;

interface ElasticSearchInterface
{
    public function search(array $statement): array;

    public function getAll(): array;

    // public function get(string $channelId): ?YoutubeChannel;

    // public function create($channel): void;

    public function add($request): bool;

    public function delete(string $channelId): void;

    public function populate(): void;

    public function clear(): void;
}
