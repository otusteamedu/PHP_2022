<?php

declare(strict_types=1);

namespace Kogarkov\Es\App;

use Kogarkov\Es\Config\Config;
use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Core\Storage\Elastic\Core as ES;
use Kogarkov\Es\Core\Storage\Elastic\Output as ESOutput;
use Kogarkov\Es\Core\Storage\Elastic\Query as ESQuery;
use Kogarkov\Es\Helper\AsciiTable;

class App
{
    private $filter = [];

    private $params = [
        '' => 'help',
        'q:' => 'query:',
        'p::' => 'maxprice::',
        'c::' => 'category::',
        's::' => 'stock::'
    ];

    public function __construct()
    {
        Registry::instance()->set('config', new Config());
        $this->fillFilter();
    }

    private function fillFilter(): void
    {
        $options = getopt(implode('', array_keys($this->params)), $this->params);

        if (isset($options['help'])) {
            throw new \Exception($this->getHelpMessage());
        }

        if (isset($options['query']) || isset($options['q'])) {
            $this->filter['query'] = isset($options['query']) ? $options['query'] : $options['q'];
        }
        if (isset($options['maxprice']) || isset($options['p'])) {
            $this->filter['maxprice'] = isset($options['maxprice']) ? $options['maxprice'] : $options['p'];
        }
        if (isset($options['category']) || isset($options['c'])) {
            $this->filter['category'] = isset($options['category']) ? $options['category'] : $options['c'];
        }
        if (isset($options['stock']) || isset($options['s'])) {
            $this->filter['stock'] = isset($options['stock']) ? $options['stock'] : $options['s'];
        }

        if (empty($this->filter['query'])) {
            throw new \Exception('Empty param q');
        }
    }

    public function run(): void
    {
        $config = Registry::instance()->get('config');
        $index_name = $config->get('es_index_name');

        $client = new ES($index_name);
        $query = new ESQuery($client->get(), $index_name);
        $result = $query->search($this->filter);

        $output_parser = new ESOutput($index_name);
        $output = $output_parser->build($result);

        $table = new AsciiTable();
        $table->makeTable($output, 'Результаты поиска');
    }

    private function getHelpMessage(): string
    {
        return "
        usage: php app.php [--help] [-q|--query=рыцари] [-c|--category=Детектив] [-p|--maxprice=3000] [-s|--stock=1]
        
        Options:
                    --help       Помощь
                -q  --query      Поисковый запрос (Обязательно)
                -c  --category   Категория
                -p  --maxprice   Максимальная стоимость книги
                -s  --stock      1 - только в наличии
        Example:
                php app.php -q=рыцори --category=Детектив --maxprice=1000
        ";
    }
}
