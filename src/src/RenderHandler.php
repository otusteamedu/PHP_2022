<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

use LucidFrame\Console\ConsoleTable;

class RenderHandler
{
    private const HEADERS = ['title', 'sku', 'category', 'price', 'stock'];
    private ConsoleTable $table;

    public function __construct()
    {
        $this->table = new ConsoleTable();
        $this->table->setHeaders(self::HEADERS);
    }

    public function setRows(array $rows): void
    {
        foreach ($rows as $row) {
            $row['stock'] = array_map(fn($item) => $item['stock'] . ' экз. на ' . $item['shop'], $row['stock']);
            $row['stock'] = implode(', ', $row['stock']);
            $this->table->addRow($row);
        }
    }

    public function render(): void
    {
        $this->table->display();
    }
}
