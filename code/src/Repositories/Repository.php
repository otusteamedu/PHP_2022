<?php

namespace Ppro\Hw13\Repositories;

use Ppro\Hw13\Register;

class Repository
{
    private RepositoryInterface $repository;
    public function __construct()
    {
        $repo = Register::instance()->getValue('db');
        $repoClass = __NAMESPACE__.'\\'.ucfirst(strtolower($repo))."Repository";
        if(!class_exists($repoClass))
            throw new \Exception('Repository class not found');
        $this->repository = new $repoClass();
    }

    public function instance()
    {
        return $this->repository;
    }
}