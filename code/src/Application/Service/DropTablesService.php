<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use PDO;

class DropTablesService implements ServiceInterface
{
    const DROP_TABLES_SQL = [
        'drop table ticket;',
        'drop table schedule;',
        'drop table cinema_hall_place_relation;',
        'drop table place;',
        'drop table film;',
        'drop table cinema_hall;',
    ];

    public function __construct(private PDO $pdo) {}

    public function execute()
    {
        foreach (self::DROP_TABLES_SQL as $sql) {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
        }
        fwrite(STDOUT, 'Таблицы удалены!' . PHP_EOL);
    }
}
