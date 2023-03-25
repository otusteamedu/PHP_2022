<?php

namespace Ppro\Hw28\Repository;

use Ppro\Hw28\Exception\AppException;

class Repository
{
    private RepositoryInterface $repository;
    public function __construct(string $repo,array $repoCredes)
    {
        $repoClass = __NAMESPACE__.'\\'.ucfirst(strtolower($repo))."Repository";
        if(!class_exists($repoClass))
            throw new AppException('Repository class not found');
        $this->repository = new $repoClass($repoCredes);
    }

    public function instance()
    {
        return $this->repository;
    }
}