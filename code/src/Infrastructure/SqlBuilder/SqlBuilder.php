<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

class SqlBuilder
{
    public static function select(): AbstractSqlCommand
    {
        return new SelectSqlCommand();
    }

    public static function delete(): AbstractSqlCommand
    {
        return new DeleteSqlCommand();
    }

    public static function insert(): AbstractSqlCommand
    {
        return new InsertSqlCommand();
    }

    public static function update(): AbstractSqlCommand
    {
        return new UpdateSqlCommand();
    }
}