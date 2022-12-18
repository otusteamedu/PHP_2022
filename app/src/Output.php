<?php

declare(strict_types=1);

namespace HW10\App;

use LucidFrame\Console\ConsoleTable;

class Output
{
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

            $stockInfo = $this->getStoreInfo($book->getStores());
            $table->addColumn(\implode(', ', $stockInfo));
            $lineNumber++;
        }

        $table->display();
    }

    private function getStoreInfo(array $stores): array
    {
        $storeInfo = [];
        foreach ($stores as $item) {
            $storeInfo[] = $item->getName() . ': ' . $item->getStore();
        }
        return $storeInfo;
    }
}