<?php

namespace Otus\Task12\Core\Routing\Contrcts;

use Otus\Task12\Core\Http\Request;

interface RouterManagerContract
{
    public function resolve(Request $request);
    public function get(string $path, mixed $handler);
}