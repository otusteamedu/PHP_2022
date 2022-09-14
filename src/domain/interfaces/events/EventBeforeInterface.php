<?php

namespace Mselyatin\Patterns\domain\interfaces\events;

interface EventBeforeInterface
{
    public function before(...$params): mixed;
}