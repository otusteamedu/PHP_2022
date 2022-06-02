<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service;


use Decole\Hw18\Domain\Repository\RecipeRepository;

class RecipeService
{
    public function __construct(private RecipeRepository $repository)
    {
    }

    public function list(): array
    {
        return $this->repository->getAll();
    }
}