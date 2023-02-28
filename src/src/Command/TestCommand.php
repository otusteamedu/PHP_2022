<?php

declare(strict_types=1);

namespace App\Command;

class TestCommand implements CommandInterface
{
    /**
     * @param array $config
     */
    public function __construct(private array $config)
    {
    }

    public function execute(): void
    {
        $pdo = new \PDO($this->config['database']['dsn']);
        $pdoStatement = $pdo->query("SELECT 'Successful connection to db' as answer");
        $result = $pdoStatement->fetch(\PDO::FETCH_ASSOC);
        echo $result['answer'] . PHP_EOL;
    }
}
