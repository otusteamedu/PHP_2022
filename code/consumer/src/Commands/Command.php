<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;

use Ppro\Hw27\Consumer\Application\Request;

abstract class Command
{
    final public function __construct()
    {
    }

    abstract public function execute();
}
