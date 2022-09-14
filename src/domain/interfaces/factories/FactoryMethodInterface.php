<?php

namespace Mselyatin\Patterns\domain\interfaces\factories;

interface FactoryMethodInterface
{
    public static function make(array $config = []);
}