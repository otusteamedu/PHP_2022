<?php

declare(strict_types=1);

namespace HW10\App;

use LucidFrame\Console\ConsoleTable;

class Output
{
    public function echo(array $outputObjs): void
    {

        $firstElemKey = array_key_first($outputObjs);
        $firstElem = $outputObjs[$firstElemKey];

        $table = new ConsoleTable();
        $table
            ->addHeader('#');

        foreach ($firstElem->map as $field) {
            $table->addHeader($field);
        }
        $table->addHeader('Наличие');

        $lineNumber = 1;
        foreach ($outputObjs as $outputObj) {
            $table->addRow()
                ->addColumn($lineNumber);

            foreach ($outputObj->getData() as $data) {
                $table->addColumn($data);
            }

            $stockInfo = $this->getStoreInfo($outputObj->getStores());
            $table->addColumn(\implode(', ', $stockInfo));
            $lineNumber++;
        }

        $table->display();
    }

    public function echoMessage(string $message): void
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('Информационное сообщение');
        $table->addRow()
            ->addColumn($message);

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
