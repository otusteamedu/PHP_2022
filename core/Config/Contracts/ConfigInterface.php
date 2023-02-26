<?php
declare(strict_types=1);

namespace Otus\Task13\Core\Config\Contracts;

interface ConfigInterface
{
    public function get($key): mixed;
}