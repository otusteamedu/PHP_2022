<?php

namespace Nsavelev\Hw6\Services\Config\Interfaces;

interface ConfigInterface
{
    /**
     * @return static
     */
    public static function getInstance(): static;

    /**
     * @param string $pathToValue
     * @return array|int|string|bool|float
     */
    public function get(string $pathToValue): array|int|string|bool|float;
}