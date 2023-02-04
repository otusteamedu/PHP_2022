<?php

namespace Nikcrazy37\Hw11\Repository;

use Nikcrazy37\Hw11\Dto\EntityDto;

interface Repository
{
    /**
     * @param EntityDto $entity
     */
    public function __construct(EntityDto $entity);

    /**
     * @param array $param
     * @param string $score
     * @return int
     */
    public function create(array $param, string $score): int;

    /**
     * @param string $id
     * @return array
     */
    public function read(string $id): array;

    /**
     * @param array $param
     * @param string $score
     * @param string $id
     * @return string
     */
    public function update(array $param, string $score, string $id): string;

    /**
     * @param string $id
     * @return string
     */
    public function delete(string $id): string;

    /**
     * @return string
     */
    public function clear(): string;
}