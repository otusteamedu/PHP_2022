<?php

namespace Ppro\Hw12\Commands;

use Ppro\Hw12\Helpers\AppContext;

class DefaultCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        throw new \Exception("Not supported app command\r\n");
    }
}