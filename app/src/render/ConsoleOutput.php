<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\render;

use LucidFrame\Console\ConsoleTable;

class ConsoleOutput implements OutputInterface
{
    public function echo(array $message): void
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
        foreach ($message as $item) {
            $source = $item['_source'];
            $table->addRow()
                ->addColumn($lineNumber)
                ->addColumn($source['sku'])
                ->addColumn($source['title'])
                ->addColumn($source['category'])
                ->addColumn($source['price']);

            $stockInfo = $this->getStockInfo($source['stock']);
            $table->addColumn(\implode(', ', $stockInfo));
            $lineNumber++;
        }

        $table->display();
    }

    /**
     * @param $stock
     * @return array
     */
    private function getStockInfo($stock): array
    {
        $stockInfo = [];
        foreach ($stock as $item) {
            $stockInfo[] = $item['shop'] . ': ' . $item['stock'];
        }
        return $stockInfo;
    }
}
