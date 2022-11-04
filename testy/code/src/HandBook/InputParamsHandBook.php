<?php

declare(strict_types=1);


namespace Mapaxa\ElasticSearch\HandBook;


class InputParamsHandBook
{
    const SHORT_OPTIONS = 't::i::c::l::h::g::f::s::';

    const LONG_OPTIONS = [
        'title',
        'sku',
        'category',
        'price',
        'stock',
        'low_price',
        'high_price',
        'limit',
        'fuzziness',
        'stock'
    ];
}