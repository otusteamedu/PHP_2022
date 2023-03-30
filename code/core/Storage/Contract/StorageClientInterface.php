<?php

declare(strict_types=1);

namespace Core\Storage\Contract;

use Core\Storage\Mysql\Query;

interface StorageClientInterface
{
    public function get(): object;
    public function query($sql): Query;
    public function escape($value): string;
    public function getLastId(): int;
    public function countAffected(): int;
}
