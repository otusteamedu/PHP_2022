<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\Service\ConsoleArgumentToElasticSearchFilterConverter;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstructController
{
    const TEMPLATE = '/Template/search.php';

    public function __invoke(Request $request)
    {
        $params = (new ConsoleArgumentToElasticSearchFilterConverter())->convert($request);
        $response = $this->elasticSearchClient->search($params);

        if ($response['hits']['total']['value'] === 0) {
            $this->dumper->dump('По вашему запросу ничего не найдено!');
        } else {
            $this->render(dirname(__DIR__) . self::TEMPLATE, $response);
        }
    }

    public function render(string $template, array $result): void
    {
        include_once $template;
    }
}