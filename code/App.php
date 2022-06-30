<?php

declare(strict_types=1);

namespace App;

use App\Service\BookFinder;
use App\Service\ConfigReader;
use App\Service\Logger\ConsoleLogger;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    private array $input;

    public function __construct()
    {
        $this->input = getopt(
            "",
            ["title::", "sku::", "category::", "in_stock", "price_from::", "price_to::", "limit::", "offset::"]
        );

        if (empty($this->input)) {
            throw new RuntimeException('Empty or wrong script parameters.');
        }

        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    /**
     * @throws AuthenticationException | ClientResponseException | ServerResponseException
     */
    public function run(): void
    {
        $logger = new ConsoleLogger();

        $client = ClientBuilder::create()->setHosts([$this->options['elasticsearch']['host']])->build();

        $finder = new BookFinder($this->options['elasticsearch']['index'], $client, $logger);
        $result = $finder->search($this->input);
        $finder->renderResultTable($result);
    }
}