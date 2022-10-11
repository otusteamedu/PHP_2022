<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\RequestConverter;

use Symfony\Component\HttpFoundation\Request;

interface RequestConverterInterface
{
    public function convert(Request $request): array;
}