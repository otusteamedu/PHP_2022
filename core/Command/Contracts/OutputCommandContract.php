<?php

namespace Otus\Task11\Core\Command\Contracts;

interface OutputCommandContract
{
    public function write(?string $message);
}