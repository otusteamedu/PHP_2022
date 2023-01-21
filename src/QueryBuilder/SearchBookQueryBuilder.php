<?php

declare(strict_types=1);

namespace Dkozlov\Otus\QueryBuilder;

class SearchBookQueryBuilder
{
    private const MORE_THAN = 'gt';

    private const LESS_THAN = 'lt';

    private array $params = [];

    public function setTitle(string $title): SearchBookQueryBuilder
    {
        $this->params['bool']['must'][]['match']['title'] = [
            'query' => $title,
            'fuzziness' => 'auto'
        ];

        return $this;
    }

    public function setInStock(): SearchBookQueryBuilder
    {
        $this->params['bool']['filter'][]['range']['stock.stock'][self::MORE_THAN] = 0;

        return $this;
    }

    public function setPriceBefore(int $priceBefore): SearchBookQueryBuilder
    {
        $this->params['bool']['filter'][]['range']['price'][self::LESS_THAN] = $priceBefore;

        return $this;
    }

    public function setPriceFrom(int $priceFrom): SearchBookQueryBuilder
    {
        $this->params['bool']['filter'][]['range']['price'][self::MORE_THAN] = $priceFrom;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}