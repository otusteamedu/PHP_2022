<?php

namespace Nikolai\Php\Service;

use Symfony\Component\HttpFoundation\Request;

interface ConsoleArgumentToElasticSearchFilterConverterInterface
{
    public function convert(Request $request): array;
}