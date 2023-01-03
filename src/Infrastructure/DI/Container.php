<?php

declare(strict_types=1);

namespace App\Infrastructure\DI;

class Container
{
    private $bindings = [];

    public function set(string $abstract, callable $factory): void {
        $this->bindings[$abstract] = $factory;
    }

    public function get(string $abstract) {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        $reflectionClass = new \ReflectionClass($abstract);

        $dependencies = $this->buildDependencies($reflectionClass);

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    private function buildDependencies(\ReflectionClass $reflectionClass)
    {
        $constructor = $reflectionClass->getConstructor();
        if (\is_null($constructor)) {
            return [];
        }

        $parameters = $constructor->getParameters();

        return \array_map(function (\ReflectionParameter $reflectionParameter) {
            $type = $reflectionParameter->getType();
            if (\is_null($type)) {
                throw new \RuntimeException('Cannot create instance of ' . $reflectionParameter->getName());
            }

            return $this->get($type->getName());
        }, $parameters);
    }
}