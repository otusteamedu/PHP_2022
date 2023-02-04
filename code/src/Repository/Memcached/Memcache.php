<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Repository\Memcached;

use Memcached;
use Nikcrazy37\Hw11\Dto\EntityDto;
use Nikcrazy37\Hw11\Repository\Repository;

class Memcache implements Repository
{
    public function __construct(EntityDto $entity)
    {
    }

    /**
     * @param array $param
     * @param string $score
     * @return int
     */
    public function create(array $param, string $score): int
    {
    }

    /**
     * @param string $id
     * @return array
     */
    public function read(string $id): array
    {
    }

    /**
     * @param array $param
     * @param string $score
     * @param string $id
     * @return string
     */
    public function update(array $param, string $score, string $id): string
    {
    }

    /**
     * @param string $id
     * @return string
     */
    public function delete(string $id): string
    {
    }

    /**
     * @return string
     */
    public function clear(): string
    {
    }
}