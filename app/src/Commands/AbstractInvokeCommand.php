<?php

namespace Nka\OtusSocketChat\Commands;

abstract class AbstractInvokeCommand
{
    public function __invoke(): void
    {
        $this->run();
    }

    abstract protected function run();
}