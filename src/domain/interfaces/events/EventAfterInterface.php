<?php

namespace Mselyatin\Patterns\domain\interfaces\events;

interface EventAfterInterface
{
    public function after(...$params): mixed;
}