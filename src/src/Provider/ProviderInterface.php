<?php

namespace App\Provider;

interface ProviderInterface
{
    public function createTable(...$params): void;

    public function deleteTable(string $tableName): void;

    public function getTable(string $tableName): array;

    public function printTable(string $tableName): void;

    public function search(array $params): array;

    public function printSearchResult(array $result): void;

    public function testConnection(): void;
}
