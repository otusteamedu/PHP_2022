<?php
declare(strict_types=1);
namespace Otus\Task11\Core\Config\Contracts;

interface ConfigContract
{
    public function get($key) : mixed;
}