<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;
use Nikolai\Php\Service\ConsoleArgumentToElasticSearchFilterConverter;
use Symfony\Component\HttpFoundation\Request;

class SearchController
{
    const TEMPLATE = '/Template/search.php';

    public function __construct(private ElasticSearchClientInterface $elasticSearchClient) {}

    public function __invoke(Request $request)
    {
        $params = (new ConsoleArgumentToElasticSearchFilterConverter())->convert($request);
        $response = $this->elasticSearchClient->search($params);

        if ($response['hits']['total']['value'] === 0) {
            echo 'По вашему запросу ничего не найдено!' . PHP_EOL;
        } else {
            $this->render(dirname(__DIR__) . self::TEMPLATE, $response);
        }
    }

    public function render(string $template, array $result): void
    {
        include_once $template;
    }
}