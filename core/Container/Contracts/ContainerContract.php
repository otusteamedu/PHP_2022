<?php

namespace Otus\Task10\Core\Container\Contracts;

interface ContainerContract
{

    public function get($id);

    public function has($id);

    public function set($id, $value);
}