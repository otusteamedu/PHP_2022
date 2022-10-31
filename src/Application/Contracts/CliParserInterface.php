<?php
declare(strict_types=1);

namespace Application\Contracts;

use Application\ValueObjects\Filter;

interface CliParserInterface
{
    public function getFilter() : Filter;
}