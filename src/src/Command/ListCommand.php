<?php

declare(strict_types=1);

namespace App\Command;

class ListCommand implements CommandInterface
{
    public function execute()
    {
        echo 'Available commands are:' . PHP_EOL . 'list' . PHP_EOL;
    }

}