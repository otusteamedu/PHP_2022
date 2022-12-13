<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

use LucidFrame\Console\ConsoleTable;

class RenderHandler
{
    private const HEADERS = ['title', 'sku', 'category', 'price', 'stock'];
    private ConsoleTable $table;

    public function _construct(): void
    {
        $this->table = new ConsoleTable();
        $this->table->setHeaders(self::HEADERS);
    }

    public function setRows(array $rows ): void
    {
        foreach ($rows as $row) {
            $this->setRow($row);
        }
    }

    public function setRow(array $row): void
    {
        $this->table->addRow($row);
    }

    public function render(): void
    {
        $this->table->display();
    }
}