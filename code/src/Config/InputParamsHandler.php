<?php

declare(strict_types=1);

namespace Otus\App\Config;

class InputParamsHandler
{
    public function __invoke(): array
    {
        return \getopt(
            '',
            [
                'title:',
                'sku:',
                'category:',
                'in_stock:',
                'price_from:',
                'price_to:',
                'limit:',
                'offset:',
            ]
        );
    }
}
