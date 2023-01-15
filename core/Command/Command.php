<?php

namespace Otus\Task10\Core\Command;

use Otus\Task10\Core\Http\Request;

abstract class Command
{
    public function execute(Request $request): void
    {
        $this->handle($request);
    }
    abstract protected function handle(Request $request): void;
}