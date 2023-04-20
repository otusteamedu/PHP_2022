<?php

namespace Svatel\Code\Domain\Pdo;

use PDO;

interface PdoDomainInterface
{
    public function getClient(): ?PDO;
}
