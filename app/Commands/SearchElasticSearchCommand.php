<?php

namespace Otus\Task10\App\Commands;

use LucidFrame\Console\ConsoleTable;
use Otus\Task10\App\Services\ElasticSearch\ProductFilterBuilder;
use Otus\Task10\Core\Command\Command;
use Otus\Task10\Core\Command\Contracts\InputContractContract;
use Otus\Task10\Core\Command\Contracts\OutputCommandContract;
use Otus\Task10\Core\Container\Container;
use Otus\Task10\Core\ElasticSearch\ElasticManager;
use Otus\Task10\Core\Http\Request;

class SearchElasticSearchCommand extends Command
{
    private ElasticManager $elasticSearchManager;
    private ConsoleTable $table;
    public function __construct(private readonly InputContractContract $arguments, private readonly OutputCommandContract $output)
    {
        $this->elasticSearchManager = Container::instance()->get('elastic');
        $this->table = new ConsoleTable();
    }

    protected function handle(Request $request): void
    {

        $elasticClient = $this->elasticSearchManager->getClient();
        $productFilterBuilder = new ProductFilterBuilder($this->arguments->getArguments());
        $result = $elasticClient->search($productFilterBuilder->toArray())->asArray();

        $this->table->setHeaders(array('Title', 'SKU', 'Category', 'Price'));
        foreach ($result["hits"]["hits"] as $product){
            $product = $product["_source"];
            $this->table->addRow([$product['title'], $product['sku'], $product['category'],  $product['price']]);
        }
        $this->output->write($this->table->getTable());
    }
}