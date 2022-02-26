<?php

declare(strict_types=1);

namespace Philip\Otus\Validators\Helpers;

class ErrorBag implements ErrorBagInterface
{
    protected array $errors = [];

    public function add(string $key, string $error): void
    {
        $this->errors[$key][] = $error;
    }

    public function all(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) !== 0;
    }

    public function clear(): void
    {
        $this->errors = [];
    }
}