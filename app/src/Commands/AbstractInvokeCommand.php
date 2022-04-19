<?php

namespace Nka\OtusSocketChat\Commands;

abstract class AbstractInvokeCommand
{
    public function __invoke()
    {
        $this->run();
    }

    abstract protected function run();
}