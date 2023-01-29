<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\View;

use LucidFrame\Console\ConsoleTable;
use Nikcrazy37\Hw10\Exception\NotFoundException;

class ViewTable extends ConsoleTable
{
    /**
     * @param array $data
     * @param array $colName
     * @return void
     * @throws NotFoundException
     */
    public function run(array $data, array $colName): void
    {
        if (empty($data["hits"]["hits"])) {
            throw new NotFoundException();
        }

        $this->setHeaders($colName);

        array_walk($data["hits"]["hits"], function ($book) use ($colName) {
            $this->addRow();

            array_walk($colName, function ($col) use ($book) {
                if (strpos($col, ".")) {
                    $param = $this->prepareNested($book, $col);
                } else {
                    $param = $book["_source"][$col];
                }

                $this->addColumn($param);
            });
        });

        $this->showAllBorders()->display();
    }

    /**
     * @param array $book
     * @param string $paramName
     * @return string
     */
    private function prepareNested(array $book, string $paramName): string
    {
        $expName = explode(".", $paramName);

        $param = "";
        array_walk($book["_source"][$expName[0]], function ($value) use ($expName, &$param) {
            $param .= $value[$expName[1]] . "\n";
        });

        return $param;
    }
}