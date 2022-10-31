<?php

declare(strict_types=1);

namespace Application;
use Application\Contracts\CliParserInterface;
use Application\Contracts\PrinterInterface;
use Application\Contracts\SearchInterface;

class App
{
    protected $cliParser;
    protected $searcher;
    protected $printer;

    /**
     * @param $cliParser
     * @param $searcher
     * @param $printer
     */
    public function __construct(CliParserInterface $cliParser, SearchInterface $searcher, PrinterInterface $printer)
    {
        $this->cliParser = $cliParser;
        $this->searcher = $searcher;
        $this->printer = $printer;
    }


    public function run() : void
    {
        $filter = $this->cliParser->getFilter();
        $books = $this->searcher->find($filter);
        $this->printer->out($books);
    }
}