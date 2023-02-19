<?php

namespace Otus\Task13\Core\Container\Contracts;

interface ContainerContract
{

    public function get($id);

    public function has($id);

    public function set($id, $value);
}