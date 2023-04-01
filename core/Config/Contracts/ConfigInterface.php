<?php
declare(strict_types=1);

namespace Otus\Task14\Core\Config\Contracts;

interface ConfigInterface
{
    public function get($key): mixed;
}