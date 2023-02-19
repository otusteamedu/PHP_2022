<?php

namespace Otus\Task13\Core\Routing\Contrcts;

use Otus\Task13\Core\Http\HttpRequest;

interface RouterManagerContract
{
    public function resolve(HttpRequest $request);

    public function get(string $path, mixed $handler);
}