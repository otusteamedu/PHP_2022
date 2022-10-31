<?php
declare(strict_types=1);

namespace Application\Contracts;

use Application\Contracts\Book;
use Application\ValueObjects\Filter;


interface SearchInterface
{
    /**
     * @param Filter $filter
     * @return Book[]
     */
    public function find(Filter $filter) : array;
}