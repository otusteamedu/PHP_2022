<?php

declare(strict_types=1);


namespace Mapaxa\ElasticSearch\Renderer;


use LucidFrame\Console\ConsoleTable;
use Mapaxa\ElasticSearch\Entity\Book\Book;

class Renderer
{
    /** @var ConsoleTable */
    private $table;

    public function __construct()
    {
        $this->table = new ConsoleTable();
    }


    private function getTableHeader(): ConsoleTable
    {
        $properties = Book::getPropertiesNames();
        foreach ($properties as $propertyName) {
            $this->table->addHeader($propertyName);
        }
        return $this->table;
    }

    public function render(array $books): void
    {
        $table = $this->getTableHeader();
        foreach ($books as $book) {
            $table
                ->addRow()
                ->addColumn($book->getSku())
                ->addColumn($book->getTitle())
                ->addColumn($book->getScore())
                ->addColumn($book->getCategory())
                ->addColumn($book->getPrice())
                ->addColumn($book->getPrettyfiedStocks());
        }
        $table->display();
    }
}