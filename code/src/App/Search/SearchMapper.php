<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Search;


use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Nikcrazy37\Hw10\Config;
use Nikcrazy37\Hw10\Exception\AppException;

class SearchMapper
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var mixed
     */
    private mixed $index;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->index = Config::getOption("INDEX");
    }

    /**
     * @return array
     * @throws AppException
     */
    public function getMap(): array
    {
        try {
            $map = $this->client
                ->indices()
                ->getMapping(array("index" => $this->index))
                ->asArray();
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new AppException($e->getMessage());
        }

        return $this->parseMap($map[$this->index]["mappings"]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function parseMap(array $data): array
    {
        $map = array();

        array_walk($data["properties"], function ($param, $paramName) use (&$map) {
            if ($param["type"] === "nested") {
                $map[$paramName] = $this->parseMap($param);

                return;
            }

            $map[$paramName] = $param["type"];
        });

        return $map;
    }
}