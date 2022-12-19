<?php
declare(strict_types=1);
namespace Otus\Task06\Core\Config\Contracts;

interface ConfigContract
{
    public function get($key) : mixed;
}