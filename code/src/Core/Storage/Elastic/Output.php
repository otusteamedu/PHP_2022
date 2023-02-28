<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Elastic;

class Output
{
    private $index_name;

    public function __construct(string $index_name)
    {
        $this->index_name = $index_name;
    }

    public function build(array $data): array
    {
        $output = [];
        if ($data['hits']['total']['value'] > 0) {
            foreach ($data['hits']['hits'] as $item) {
                $output[] = $this->buildOutput($item);
            }
        } else {
            $output[] = $this->buildEmptyOutput();
        }

        return $output;
    }

    private function buildOutput(array $item): array
    {
        switch ($this->index_name) {
            case 'otus-shop':
                $stock_str = '';

                foreach ($item['_source']['stock'] as $stock) {
                    if ($stock['stock'] > 0) {
                        $stock_str .= $stock['shop'] . ': ' . $stock['stock'] . '; ';
                    }
                }
        
                return [
                    'Наименование' => $item['_source']['title'],
                    'SKU' => $item['_source']['sku'],
                    'Категория' => $item['_source']['category'],
                    'Цена' => $item['_source']['price'],
                    'Наличие' => $stock_str
                ];
            default:
                return [];
        }
        
    }

    private function buildEmptyOutput(): array
    {
        switch ($this->index_name) {
            case 'otus-shop':
                return [
                    'Наименование' => '',
                    'SKU' => '',
                    'Категория' => '',
                    'Цена' => '',
                    'Наличие' => '',
                ];
            default:
                return [];
        }
    }
}
