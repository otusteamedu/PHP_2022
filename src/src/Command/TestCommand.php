<?php

declare(strict_types=1);

namespace App\Command;

use App\Storage\StorageInterface;

class TestCommand implements CommandInterface
{
    private string $result;

    public function __construct(private StorageInterface $storage)
    {
    }

    public function execute(): void
    {
        $this->result = $this->storage->testConnection();
    }


    public function printResult(): void
    {
        echo $this->result . PHP_EOL;
    }
}
