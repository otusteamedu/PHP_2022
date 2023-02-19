<?php

namespace Otus\Task13\Core\Command\Contracts;

interface OutputCommandContract
{
    public function write(?string $message);
}