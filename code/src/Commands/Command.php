<?php

namespace Ppro\Hw15\Commands;

abstract class Command
{
    abstract public function execute(): void;
}