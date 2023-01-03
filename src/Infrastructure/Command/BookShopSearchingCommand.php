<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\App\Service\BookShopRepository;

class BookShopSearchingCommand implements CommandInterface
{
    private BookShopRepository $repository;

    public static function getDescription(): string
    {
        return 'Осуществляет поиск в магазине по заданным параметрам';
    }

    public function __construct(BookShopRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): void
    {
        var_dump($this->repository->search());
    }
}