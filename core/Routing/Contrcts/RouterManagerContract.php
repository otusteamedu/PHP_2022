<?php

namespace Otus\Task14\Core\Routing\Contrcts;

use Otus\Task14\Core\Http\HttpRequest;

interface RouterManagerContract
{
    public function resolve(HttpRequest $request);

    public function get(string $path, mixed $handler);
}