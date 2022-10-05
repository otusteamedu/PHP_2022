<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

abstract class AbstractController
{
    abstract function __invoke(...$values);
}