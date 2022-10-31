<?php
declare(strict_types=1);

namespace Infrastructure\Views;


use Application\Contracts\PrinterInterface;
use Domain\ValueObjects\Book;
use Domain\ValueObjects\Stock;
use LucidFrame\Console\ConsoleTable;


class Printer implements PrinterInterface
{

    public function out(array $books): void
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('Title')
            ->addHeader('Category')
            ->addHeader('Sku')
            ->addHeader('Price')
            ->addHeader('Stocks')
        ;

        /** @var Book $book */
        foreach ($books as $book)
        {
            $stoks = $book->getStocks();
            /** @var Stock $stock */
            $strStock = '';
            foreach ($stoks as $stock)
            {
                $strStock.=$stock->getTitle()."(".$stock->getQuantity().") ";
            }
            $table
                ->addRow()
                ->addColumn($book->getName())
                ->addColumn($book->getCategory())
                ->addColumn($book->getSku())
                ->addColumn($book->getPrice())
                ->addColumn($strStock);
        }

        $table->display();
    }
}