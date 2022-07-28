<?php

declare(strict_types=1);

use Domain\Contract\StorageInterface;
use Infrustructure\Storage\RedisStorage;

use function DI\autowire;

return [
    StorageInterface::class => autowire(RedisStorage::class),
];