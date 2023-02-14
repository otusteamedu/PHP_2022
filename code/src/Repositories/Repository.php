<?php

namespace Ppro\Hw15\Repositories;

use Ppro\Hw15\Register;

class Repository
{
    /**
     * @var RepositoryInterface|mixed
     */
    private RepositoryInterface $repository;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $repo = Register::instance()->getValue('db');
        $repoClass = __NAMESPACE__.'\\'.ucfirst(strtolower($repo))."Repository";
        if(!class_exists($repoClass))
            throw new \Exception('Repository class not found');
        $this->repository = new $repoClass();
    }

    /**
     * @return mixed|RepositoryInterface
     */
    public function instance()
    {
        return $this->repository;
    }
}