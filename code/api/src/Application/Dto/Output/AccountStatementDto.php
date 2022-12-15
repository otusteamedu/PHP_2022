<?php

declare(strict_types=1);

namespace App\Application\Dto\Output;

use Symfony\Component\Uid\Uuid;

class AccountStatementDto
{
    public ?Uuid $id = null;
    public ?string $text = null;
}