<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\View;

use LucidFrame\Console\ConsoleTable;

class ViewTable extends ConsoleTable
{
    /**
     * @param array $data
     * @return void
     */
    public function run(array $data): void
    {
        $this->setHeaders(ViewConfig::HEADERS);

        array_walk($data["hits"]["hits"], function ($book, $key) {
            $book = $book["_source"];

            $stock = $this->prepareStock($book["stock"]);

            $this->addRow(array(
                ++$key,
                $book["title"],
                $book["sku"],
                $book["category"],
                $book["price"],
                $stock
            ));
        });

        $this->showAllBorders()->display();
    }

    /**
     * @param array $stocks
     * @return string
     */
    private function prepareStock(array $stocks): string
    {
        $text = "";
        array_walk($stocks, function ($stock) use (&$text) {
            $text .= "{$stock["shop"]} - {$stock["stock"]} шт.\n";
        });

        return $text;
    }
}