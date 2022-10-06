<?php

namespace Nikolai\Php\Service;

use Symfony\Component\HttpFoundation\Request;

interface ElasticSearchParametersVerifierInterface
{
    public function verify(Request $request): void;
}