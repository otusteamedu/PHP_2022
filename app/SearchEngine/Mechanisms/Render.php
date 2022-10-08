<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

use LucidFrame\Console\ConsoleTable;

final class Render
{
    private ConsoleTable $table;
    private array $search_results;

    /**
     * @param array $search_results
     */
    public function __construct(array $search_results)
    {
        $this->table = new ConsoleTable();
        $this->search_results = $search_results;
    }

    /**
     * @return void
     */
    public function redner(): void
    {
        $this->table
            ->addHeader(content: 'Title')
            ->addHeader(content: 'Sku')
            ->addHeader(content: 'Category')
            ->addHeader(content: 'Price')
            ->addHeader(content: 'Shop and Stock');

        foreach ($this->search_results['hits']['hits'] as $result) {
            $this->table
                ->addRow()
                ->addColumn($result['_source']['title'] ?? 'n/a')
                ->addColumn($result['_source']['sku'] ?? 'n/a')
                ->addColumn($result['_source']['category'] ?? 'n/a')
                ->addColumn($result['_source']['price'] ?? 'n/a');

            $shop_and_stock = implode(
                separator: '; ',
                array: array_map(
                    callback: fn ($value) => $value['shop'] . ' - ' . $value['stock'] . ' шт.',
                    array: $result['_source']['stock']
                )
            );

            $this->table->addColumn(content: $shop_and_stock);
        }

        $this->table->display();
    }
}
