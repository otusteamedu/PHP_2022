<?php

namespace App\Db\Database;

interface Entity
{
    public function getId(): int;
    public function toArray(): array;
}
