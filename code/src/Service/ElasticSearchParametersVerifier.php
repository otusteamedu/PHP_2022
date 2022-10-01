<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Exception\ElasticSearchException;
use Symfony\Component\HttpFoundation\Request;

class ElasticSearchParametersVerifier implements ElasticSearchParametersVerifierInterface
{
    const REQUIRE_PARAMETERS = [
        'ELASTICSEARCH_PORT',
        'ELASTICSEARCH_HOST',
        'ELASTICSEARCH_FILE'
    ];

    public function verify(Request $request): void
    {
        foreach (self::REQUIRE_PARAMETERS as $parameter) {
            $value = $request->server->get($parameter);
            if (!$value || strlen($value) <= 0) {
                throw new ElasticSearchException('В .env не указан обязательный параметр: ' . $parameter);
            }
        }
    }
}