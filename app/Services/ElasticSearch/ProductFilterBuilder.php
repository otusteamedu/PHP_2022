<?php
namespace Otus\Task10\App\Services\ElasticSearch;

class ProductFilterBuilder
{
    const INDEX = 'otus-shop';

    private array $params = [];

    public function __construct(private readonly array $filterParams)
    {
        $this->params['index'] = self::INDEX;
        $this->parserParameters();
    }

    public function parserParameters(): void
    {
        $query = [];

        foreach ($this->filterParams as $param){
            if(str_contains($param, ':')){
                [$field, $value] = explode(':', $param);

                if($field === 'title'){
                    $query['bool']['must'][] = ['match' => ['title' => ['query' => $value, "fuzziness" => 'auto']]];
                }

                if($field === 'category'){
                    $query['bool']['must'][] = ['term' => ['category' => $value]];
                }

                if($field === 'price_range'){
                    [$more, $less] = explode('-', $value);
                    if($more && $less){
                        $query['bool']['must'][] = ['range' => ['price' => ['gte' => $more, 'lte' => $less]]];
                    }
                }
                if($field === 'price_low'){
                    $query['bool']['must'][] = ['range' => ['price' => ['lte' => $value]]];
                }

                if($field === 'in_store'){
                    $query['bool']['must'][] = ["nested"=>["path"=>"stock","query"=>["bool"=>["filter"=>[["range" =>[ "stock.stock" =>[ "gt" => 0]]]]]]]];
                }
            }
        }

        if($query){
            $this->params['body']['query'] = $query;
        }
    }

    public function toArray(): array{
        return $this->params;
    }
}