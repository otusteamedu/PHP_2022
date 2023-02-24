<?php

declare(strict_types=1);

namespace App\Providers\Elastic\Query;

interface QueryInterface
{
    public function execute(): void;
}