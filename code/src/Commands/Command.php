<?php

namespace Ppro\Hw12\Commands;

use Ppro\Hw12\Helpers\AppContext;

abstract class Command
{
    abstract public function execute(AppContext $context): void;
}