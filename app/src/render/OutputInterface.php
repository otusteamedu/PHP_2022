<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\render;

use Nemizar\OtusShop\entity\Book;

interface OutputInterface
{
    /**
     * @param Book[] $books
     * @return void
     */
    public function echo(array $books): void;
}
