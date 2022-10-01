<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;

class NestedTypePropertyConverter extends AbstractTypePropertyConverter
{
    const CONVERTER_CLASS_POSTFIX = 'TypePropertyConverter';
    const NAMESPACE = 'Nikolai\Php\Converter\\';


    public function convert(): array
    {
        $propertyNames = explode('.', $this->item[0]);
        $typeProperty = ucfirst(
            ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES[$propertyNames[0]]["properties"][$propertyNames[1]]['type']
        );
        $class = self::NAMESPACE . $typeProperty . self::CONVERTER_CLASS_POSTFIX;

        return [
            "nested" => [
                "path" => $propertyNames[0],
                "query" => (new $class($this->item))->convert()
            ]
        ];
    }
}
