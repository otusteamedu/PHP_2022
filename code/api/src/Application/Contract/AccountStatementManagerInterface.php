<?php

declare(strict_types=1);

namespace App\Application\Contract;

use App\Application\Dto\Input\SaveAccountStatementDto;
use App\Application\Dto\Output\AccountStatementDto as OutputAccountStatementDto;
use Symfony\Component\Uid\Uuid;

interface AccountStatementManagerInterface
{
    public function create(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void;
    public function update(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void;
    public function delete(Uuid $id): void;
    public function find(Uuid $id): ?OutputAccountStatementDto;
    public function findAll(): iterable;
}