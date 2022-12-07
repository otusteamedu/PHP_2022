<?php

namespace Ppro\Hw7\Commands;

use Ppro\Hw7\Helper\AppContext;

class DefaultCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        throw new \Exception("Not supported app role");
    }
}