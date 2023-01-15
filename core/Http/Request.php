<?php
declare(strict_types=1);

namespace Otus\Task11\Core\Http;

abstract class Request
{
    protected string $path = '/';
    protected array $properties = [];
    public function __construct()
    {
        $this->initialize();
    }

    abstract public function initialize();

    abstract public function getPath();

    public function getMethod():string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string{
        return '/';
    }

    public function getProperties(): array{
        return $this->properties;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }



}