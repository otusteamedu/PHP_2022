<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

interface SqlBuilderFactoryInterface
{
    public function select(): AbstractSqlCommand;
    public function delete(): AbstractSqlCommand;
    public function insert(): AbstractSqlCommand;
    public function update(): AbstractSqlCommand;
}