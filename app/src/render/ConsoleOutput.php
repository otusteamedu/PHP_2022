<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\render;

use LucidFrame\Console\ConsoleTable;
use Nemizar\OtusShop\entity\Book;

class ConsoleOutput implements OutputInterface
{
    /**
     * @param Book[] $books
     * @return void
     */
    public function echo(array $books): void
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('#')
            ->addHeader('SKU')
            ->addHeader('Заголовок')
            ->addHeader('Категория')
            ->addHeader('Цена')
            ->addHeader('Наличие');

        $lineNumber = 1;
        foreach ($books as $book) {
            $table->addRow()
                ->addColumn($lineNumber)
                ->addColumn($book->getSku())
                ->addColumn($book->getTitle())
                ->addColumn($book->getCategory())
                ->addColumn($book->getPrice());

            $stockInfo = $this->getStockInfo($book->getStocks());
            $table->addColumn(\implode(', ', $stockInfo));
            $lineNumber++;
        }

        $table->display();
    }

    /**
     * @param \Nemizar\OtusShop\entity\Stock[] $stock
     * @return array
     */
    private function getStockInfo(array $stock): array
    {
        $stockInfo = [];
        foreach ($stock as $item) {
            $stockInfo[] = $item->getName() . ': ' . $item->getStock();
        }
        return $stockInfo;
    }
}
