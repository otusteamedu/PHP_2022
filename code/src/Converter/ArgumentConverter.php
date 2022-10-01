<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;
use Nikolai\Php\Exception\ConverterException;

class ArgumentConverter implements ArgumentConverterInterface
{
    const CONVERTER_CLASS_POSTFIX = 'TypePropertyConverter';
    const NAMESPACE = 'Nikolai\Php\Converter\\';
    const NESTED_TYPE_PROPERTY = 'Nested';

    private PropertyVerifiedInterface $propertyVerified;

    public function __construct(private string $argumentValue) {
        $this->propertyVerified = new PropertyVerified(ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES);
    }

    public function convert(): array
    {
        return array_map(function (string $stringItem) {
            $item = explode(ArgumentConverterInterface::VALUE_SEPARATOR, $stringItem);

            $this->propertyVerified->verify($item[0]);

            $typeProperty = str_contains($item[0], '.') ?
                self::NESTED_TYPE_PROPERTY :
                ucfirst(ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES[$item[0]]['type']);

            $class = self::NAMESPACE . $typeProperty . self::CONVERTER_CLASS_POSTFIX;

            return (new $class($item))->convert();
        }, explode(ArgumentConverterInterface::ITEM_SEPARATOR, $this->argumentValue));
    }
}