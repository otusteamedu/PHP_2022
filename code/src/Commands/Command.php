<?php

namespace Ppro\Hw7\Commands;

use Ppro\Hw7\Helper\AppContext;

abstract class Command
{
    abstract public function execute(AppContext $context);
}