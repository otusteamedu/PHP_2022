<?php

declare(strict_types=1);

namespace Otus\App\Viewer;

use LucidFrame\Console\ConsoleTable;

class ConsoleOutput implements OutputInterface
{
    /**
     * Build books table
     * @param array $books
     * @return void
     */
    public function echo(array $books): void
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('#')
            ->addHeader('SKU')
            ->addHeader('Название')
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
     * @param array $stock
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
