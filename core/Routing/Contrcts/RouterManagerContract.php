<?php

namespace Otus\Task11\Core\Routing\Contrcts;

use Otus\Task11\Core\Http\Request;

interface RouterManagerContract
{
    public function resolve(Request $request);
    public function get(string $path, mixed $handler);
}