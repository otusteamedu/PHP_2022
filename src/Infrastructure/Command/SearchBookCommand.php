<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Infrastructure\Command;

use Dkozlov\Otus\Application\QueryBuilder\SearchBookQueryBuilder;
use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Domain\Book;
use Throwable;

class SearchBookCommand extends AbstractCommand
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        array                                $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        $query = $this->constructSearchBookQueryBuilder();

        try {
            $response = $this->repository->search($query);

            $this->printBooks($response);
        } catch (Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * @param Book[] $books
     * @return void
     */
    private function printBooks(array $books): void
    {
        if (empty($books)) {
            echo 'No books were found for the specified parameters' . PHP_EOL;
        } else {
            foreach ($books as $book) {
                $stockText = ($book->isInStock()) ? 'in stock' : 'out of stock';

                echo "{$book->getSku()} - {$book->getTitle()} - {$book->getCost()} - {$stockText}" . PHP_EOL;
            }
        }
    }

    private function constructSearchBookQueryBuilder(): SearchBookQueryBuilder
    {
        $query = new SearchBookQueryBuilder();

        $title = $this->args['title'] ?? '';
        $inStock = isset($this->args['instock']);
        $priceFrom = $this->args['priceFrom'] ?? '';
        $priceBefore = $this->args['priceBefore'] ?? '';

        if ($title) {
            $query->setTitle($title);
        }

        if ($inStock) {
            $query->setInStock();
        }

        if ($priceFrom) {
            $query->setPriceFrom((int) $priceFrom);
        }

        if ($priceBefore) {
            $query->setPriceBefore((int) $priceBefore);
        }

        return $query;
    }
}