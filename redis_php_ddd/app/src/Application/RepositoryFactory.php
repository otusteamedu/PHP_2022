<?php

namespace App\Ddd\Application;

interface RepositoryFactory
{
    public function create(): ?Repository;
}