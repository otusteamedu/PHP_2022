<?php

namespace Infrastructure\Controllers;

use Application\Contracts\CliParserInterface;
use Garden\Cli\Cli;
use Application\ValueObjects\Filter;

class CliParser implements CliParserInterface
{
    protected Cli $cli;

    public function __construct()
    {
        // Define the cli options.
        $this->cli = new Cli();

        $this->cli->description('Dump some information from your database.')
            ->opt('name:n', 'Name for search', false)
            ->opt('category:c', 'Category for search', false)
            ->opt('maxprice:max', 'Max price', false)
            ->opt('minprice:min', 'Min price', false)
            ->opt('stock:s', 'Min quantity', false,'integer');
    }

    public function getFilter(): Filter
    {

        $args =$this->cli->parse($argv, true);


        $name = $args->getOpt('name');
        $cat = $args->getOpt('category');
        $max = $args->getOpt('maxprice');
        $min = $args->getOpt('minprice');
        $stock = $args->getOpt('stock');

        return new Filter($name, $cat, $max, $min, intval($stock));
    }
}