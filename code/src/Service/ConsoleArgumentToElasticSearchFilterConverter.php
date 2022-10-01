<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Converter\ArgumentConverter;
use Nikolai\Php\Converter\ArgumentConverterInterface;
use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;
use Nikolai\Php\Exception\ConverterException;
use Symfony\Component\HttpFoundation\Request;

class ConsoleArgumentToElasticSearchFilterConverter implements ConsoleArgumentToElasticSearchFilterConverterInterface
{
    const ALLOWED_ARGUMENTS = [
        'must',
        'must not',
        'filter',
        'should'
    ];

    public function convert(Request $request): array
    {
        $result = [];

        foreach (array_slice($request->server->get('argv'), 2) as $arg) {
            $argument = explode(ArgumentConverterInterface::SEPARATOR, $arg);

            if (!in_array($argument[0], self::ALLOWED_ARGUMENTS)) {
                throw new ConverterException('Недопустимое имя аргумента: ' . $argument[0]);
            }

            $result[$argument[0]] = (new ArgumentConverter($argument[1]))->convert();
        }

        return [
            'index' => ElasticSearchClientInterface::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => $result
                ]
            ]
        ];
    }
}
