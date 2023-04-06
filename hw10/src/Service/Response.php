<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\Service;

use Console_Table;

class Response
{
    private ConsoleTable $table;

    public function __construct()
    {
        $this->table = new ConsoleTable();
    }

    public function getResult(array $rows)
    {
        foreach ($rows as $row) {
            $row['stock'] = array_map(fn($item) => $item['stock'] . ' ' . $item['shop'], $row['stock']);
            $row['stock'] = implode(', ', $row['stock']);
            $this->table->addRow($row);
        }
        echo $this->table->getTable();
    }
}