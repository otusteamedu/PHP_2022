<?php

namespace Nikolai\Php\Service;

interface StringVerifierInterface
{
    public function verify(string $string): string;
}