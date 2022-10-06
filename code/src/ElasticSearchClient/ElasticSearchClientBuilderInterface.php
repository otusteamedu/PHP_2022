<?php

namespace Nikolai\Php\ElasticSearchClient;

use Symfony\Component\HttpFoundation\Request;

interface ElasticSearchClientBuilderInterface
{
    public static function create(Request $request): ElasticSearchClientInterface;
}