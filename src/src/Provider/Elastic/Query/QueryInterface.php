<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query;

interface QueryInterface
{
    public function execute(): void;
}
