<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;

class ArgumentConverter implements ArgumentConverterInterface
{
    const CONVERTER_CLASS_POSTFIX = 'TypePropertyConverter';
    const NAMESPACE = 'Nikolai\Php\Converter\\';
    const NESTED_TYPE_PROPERTY = 'Nested';

    private PropertyVerifiedInterface $propertyVerified;

    public function __construct(private string $argumentValue) {
        $this->propertyVerified = new PropertyVerified(ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES);
    }

    /**
     * Парсинг допустимого аргумента (.AND.).
     * Например, из: title:преключения.AND.price:lt:10000
     * будет цикл:
     *      - title:преключения
     *      - price:lt:10000
     * Далее, парсятся уже элементы цикла:
     *      - title:преключения - поле title ищется в mapping-е индекса, и определяется тип поля.
     *      По нему создается экземпляр класса: "Тип поля" + TypePropertyConverter, например TextTypePropertyConverter.
     *      - price:lt:10000 - тоже самое, ShortTypePropertyConverter.
     *
     *      - category:Фантастика - KeywordTypePropertyConverter
     *      - stock.stock:lt:10 - NestedTypePropertyConverter
     *
     * Для типов полей
     */
    public function convert(): array
    {
        $result = [];

        foreach (explode(ArgumentConverterInterface::ITEM_SEPARATOR, $this->argumentValue) as $stringItem)
        {
            $item = explode(ArgumentConverterInterface::VALUE_SEPARATOR, $stringItem);

            $this->propertyVerified->verify($item[0]);

            $typeProperty = str_contains($item[0], '.') ?
                self::NESTED_TYPE_PROPERTY :
                ucfirst(ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES[$item[0]]['type']);

            $class = self::NAMESPACE . $typeProperty . self::CONVERTER_CLASS_POSTFIX;

            $result[] = (new $class($item))->convert();
        }

        return $result;
    }
}