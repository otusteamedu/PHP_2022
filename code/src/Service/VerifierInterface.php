<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

interface VerifierInterface
{
    public function verify(string $string): void;
}