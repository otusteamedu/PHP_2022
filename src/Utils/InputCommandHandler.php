<?php

declare(strict_types=1);

namespace Pinguk\ElasticApp\Utils;

class InputCommandHandler
{
    public function handle(): array
    {
        $longopts = [
            'category::',
            'price::',
            'sku::',
            'shop::',
            'stock::',
            'title::'
        ];

        return getopt('', $longopts);
    }
}
