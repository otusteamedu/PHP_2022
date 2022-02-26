<?php

namespace Philip\Otus\Validators\Helpers;

interface ErrorBagInterface
{
    public function add(string $key, string $error): void;

    public function all(): array;

    public function hasErrors(): bool;

    public function clear(): void;
}