<?php

namespace Ppro\Hw15\Commands;

class DefaultCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        throw new \Exception("App cmd error\r\n");
    }
}