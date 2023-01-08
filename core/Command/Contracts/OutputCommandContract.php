<?php

namespace Otus\Task10\Core\Command\Contracts;

interface OutputCommandContract
{
    public function write(?string $message);
}