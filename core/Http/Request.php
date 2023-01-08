<?php
declare(strict_types=1);

namespace Otus\Task10\Core\Http;

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

    public function getProperties(): array{
        return $this->properties;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }



}