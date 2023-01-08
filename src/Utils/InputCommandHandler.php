<?php

declare(strict_types=1);

namespace Pinguk\ElasticApp\Utils;

class InputCommandHandler
{
    public function handle(): array
    {
        $longopts = [
            'category::',
            'priceGt::',
            'priceLt::',
            'sku::',
            'shop::',
            'title::',
            'in-stock::'
        ];

        return getopt('', $longopts);
    }
}
