<?php

namespace Ppro\Hw13\Commands;

abstract class Command
{
    abstract public function execute(): void;
}