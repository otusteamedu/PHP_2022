<?php

namespace Otus\Task12\Core\Command\Contracts;

interface OutputCommandContract
{
    public function write(?string $message);
}