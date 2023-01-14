<?php

declare(strict_types=1);

namespace Otus\App\Core;

/**
 * Data repository
 */
interface RepositoryInterface
{
    /**
     * Search data
     * @param array $params
     * @return array
     */
    public function search(array $params): array;

    /**
     * Get params
     * @param array $params
     * @return array
     */
    public function getPreparedParams(array $params): array;

    /**
     * Format result
     * @param array $result
     * @return array
     */
    public function formatResult(array $result): array;
}
