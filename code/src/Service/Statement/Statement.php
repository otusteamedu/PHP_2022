<?php

namespace Ppro\Hw28\Service\Statement;

use Ppro\Hw28\Repository\Repository;
use Ppro\Hw28\Repository\RepositoryInterface;

/**
 *
 */
class Statement
{
    protected RepositoryInterface $repository;
    public function __construct(Repository $repository)
    {
        $this->repository = $repository->instance();
    }
}