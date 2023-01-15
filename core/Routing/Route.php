<?php

namespace Otus\Task11\Core\Routing;

use Otus\Task11\Core\Http\Response;

class Route
{
    public function __construct(private readonly string $method, private readonly string $path, private readonly mixed $handler){}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function run(): mixed{
        if(is_array($this->handler)){
            [$class, $method] = $this->handler;
           return call_user_func_array([new $class(), $method], []);
        }
    }
}