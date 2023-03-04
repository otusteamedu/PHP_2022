<?php

declare(strict_types=1);

namespace App\Command;

use PDO;

class TestCommand implements CommandInterface
{
    private array $result;

    public function __construct(private array $config)
    {
    }

    public function execute(): void
    {
        $pdo = new PDO($this->config['database']['dsn']);
        $pdoStatement = $pdo->query("SELECT 'Successful connection to db' as answer");
        $this->result = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }


    public function printResult(): void
    {
        echo $this->result['answer'] . PHP_EOL;
    }
}
