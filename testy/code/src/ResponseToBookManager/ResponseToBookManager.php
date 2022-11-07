<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\ResponseToBookManager;

use Mapaxa\ElasticSearch\Entity\Book\BookFactory;

class ResponseToBookManager
{

    /** @var BookFactory */
    private $bookFactory;

    public function __construct()
    {
        $this->bookFactory = BookFactory::class;

    }
    
    public function getBooksFromResponse(array $response): array
    {
        $booksResponse = $response['hits']['hits'];
        $books = [];
        foreach ($booksResponse as $book) {
            $books[] = $this->bookFactory::create(
                $book['_source']['sku'],
                $book['_source']['title'],
                (float)$book['_score'],
                $book['_source']['category'],
                $book['_source']['price'],
                $book['_source']['stock']
            );
        }
        return $books;
    }
}