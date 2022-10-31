<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Application\Contracts\Book;
use Application\Contracts\SearchInterface;
use Application\ValueObjects\Filter;
use Domain\ValueObjects\Stock;
use Elastic\Elasticsearch\ClientBuilder;

class Search implements SearchInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200']) // указываем, в виде массива, хост и порт сервера elasticsearch
            ->build();
    }

    /**
     * @inheritDoc
     */
    public function find(Filter $filter): array
    {
        $books = [];

        $isFilterSet = false;

        $params = [
            'index' => 'books', // по какому индексу ищем
            'size' => 100 // количество результатов выборки
        ];

        if ($filter->getName()!==null)
        {
            $isFilterSet = true;
            $q=mb_convert_encoding($filter->getName(), 'UTF8', "Windows-1251");
            $params['body']['query']['bool']['must'][]=["match"=>["title"=>["query"=>$q, "fuzziness"=>"AUTO"]]];
        }

        if ($filter->getCategory()!==null)
        {
            $isFilterSet = true;
            $q=mb_convert_encoding($filter->getCategory(), 'UTF8', "Windows-1251");
            $params['body']['query']['bool']['must'][]=["match"=>["category"=>["query"=>$q, "fuzziness"=>"AUTO"]]];
        }

        if ($filter->getMaxPrice()!==null)
        {
            $isFilterSet = true;
            $params['body']['query']['bool']['filter'][]=["range"=>["price"=>["lt"=>$filter->getMaxPrice()]]];
        }

        if ($filter->getMinPrice()!==null)
        {
            $isFilterSet = true;
            $params['body']['query']['bool']['filter'][]=["range"=>["price"=>["gt"=>$filter->getMinPrice()]]];
        }

        if ($filter->getMinStock()>0)
        {
            $isFilterSet = true;
            $params['body']['query']['bool']['filter'][]=["range"=>["stock.stock"=>["gt"=>$filter->getMinStock()]]];
        }

        if ($isFilterSet ) {
            $result = $this->client->search($params);
            foreach ($result['hits']['hits'] as $item) {
                $res = mb_convert_encoding($item["_source"], 'WINDOWS-1251', mb_detect_encoding($item["_source"]['title']));

                $stocks = array();
                foreach ($res['stock'] as $stock) {
                    $stocks[] = new Stock($stock['shop'], $stock['stock']);
                }

                $books[] = new \Domain\ValueObjects\Book($res['title'], $res['category'], $res['sku'], $res['price'], $stocks);
            }
        }

        return $books;

    }
}