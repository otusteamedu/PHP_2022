<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

class SqlBuilderFactory implements SqlBuilderFactoryInterface
{
    public function select(): AbstractSqlCommand
    {
        return new SelectSqlCommand();
    }

    public function delete(): AbstractSqlCommand
    {
        return new DeleteSqlCommand();
    }

    public function insert(): AbstractSqlCommand
    {
        return new InsertSqlCommand();
    }

    public function update(): AbstractSqlCommand
    {
        return new UpdateSqlCommand();
    }
}