<?php

namespace Otus\Task06\Core\Command;

use Otus\Task06\Core\Http\Request;

abstract class Command
{
    public function execute(Request $request): void
    {
        $this->handle($request);
    }
    abstract protected function handle(Request $request): void;
}