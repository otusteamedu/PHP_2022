<?php

namespace Nikolai\Php\Service;

interface DumperInterface
{
    public function dump(string $header, ?array $var = []): void;
}