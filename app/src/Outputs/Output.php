<?php

namespace HW10\App\Outputs;

use HW10\App\Interfaces\OutputInterface;
use LucidFrame\Console\ConsoleTable;

class Output implements OutputInterface
{
    public function echoMessage(string $message): void
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('Информационное сообщение');
        $table->addRow()
            ->addColumn($message);

        $table->display();
    }
}
