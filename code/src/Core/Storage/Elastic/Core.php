<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Elastic;

use Kogarkov\Es\Core\Service\Registry;
use Elastic\Elasticsearch\ClientBuilder;
use GuzzleHttp\Client as HttpClient;

class Core
{
    private $client;
    private $config;
    private $index_name;
    private $index_map;

    public function __construct($index_name)
    {
        $this->config = Registry::instance()->get('config');
        $this->client = ClientBuilder::create()
            ->setHttpClient(new HttpClient(['verify' => false]))
            ->setHosts([$this->config->get('es_host')])
            ->build();
        $this->index_name = $index_name;
        $this->index_map = new IndexMap();
        $this->init();
    }

    public function get(): object
    {
        return $this->client;
    }

    private function init(): void
    {
        if (!$this->indexIsExists()) {
            $this->createIndex();
            $this->importIndex();
        }
    }

    private function createIndex(): void
    {
        $body = $this->index_map->getIndex($this->index_name);
        $this->client->indices()->create([
            'index' => $this->index_name,
            'body' => $body
        ]);
    }

    private function importIndex(): void
    {
        $file = file_get_contents($this->config->get('es_index_import_file_path'));
        if ($file) {
            if ($data = explode(PHP_EOL, $file)) {
                $params['body'] = [];
                foreach ($data as $i => $json_row) {
                    $row = json_decode($json_row, true);
                    if ($row == null) {
                        continue;
                    }
                    if ($i % 2) {
                        $params['body'][] = $this->buildRow($row);
                    } else {
                        $row = reset($row);
                        $params['body'][] = [
                            'index' => [
                                '_index' => $this->index_name,
                                '_id' => $row['_id']
                            ]
                        ];
                    }
                }
                $this->client->bulk($params);
            }
        }
    }

    private function indexIsExists(): bool
    {
        return $this->client->indices()->exists(['index' => $this->index_name])->asBool();
    }

    private function buildRow($row): array
    {
        $fields = $this->index_map->getIndexFields($this->index_name);
        $result = [];
        foreach ($fields as $field) {
            $result[$field] = $row[$field];
        }
        return $result;
    }
}
