<?php

namespace Otus\Task14\Core\Http;

use Otus\Task14\Core\Http\Contract\HttpRequestInterface;
use Otus\Task14\Core\Http\Parameters\PostParameter;

class HttpRequest implements HttpRequestInterface
{
    protected string $path = '/';
    protected array $properties = [];
    private PostParameter $post;

    public function __construct(array $post)
    {
        $this->post = new PostParameter($post);
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }


    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function getPost(): PostParameter
    {
        return $this->post;
    }
}