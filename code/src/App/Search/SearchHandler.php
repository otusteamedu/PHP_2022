<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Search;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Nikcrazy37\Hw10\Config;
use Nikcrazy37\Hw10\Exception\AppException;

class SearchHandler
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var SearchBuilder
     */
    private SearchBuilder $build;

    /**
     * @var SearchMapper
     */
    private SearchMapper $mapper;

    /**
     * @var array
     */
    private array $map;

    /**
     * @throws AppException
     */
    public function __construct()
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([Config::getOption("HOST")])
                ->build();
        } catch (AuthenticationException $e) {
            throw new AppException($e->getMessage());
        }

        $this->mapper = new SearchMapper($this->client);
        $this->map = $this->mapper->getMap();

        $this->build = new SearchBuilder();
    }

    /**
     * @param array $inputParam
     * @return array
     * @throws AppException
     */
    public function run(array $inputParam): array
    {
        $this->buildSearch($inputParam);

        try {
            $search = $this->client->search($this->build->getQuery());
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new AppException($e->getMessage());
        }

        return $search->asArray();
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = array();

        array_walk($this->map, function ($value, $name) use (&$headers) {
            if (is_array($value)) {
                array_walk($value, function ($value, $nestedName) use (&$headers, $name) {
                    $headers[] = "$name.$nestedName";
                });

                return;
            }

            $headers[] = $name;
        });

        return $headers;
    }

    /**
     * @param array $inputParam
     * @return void
     */
    private function buildSearch(array $inputParam): void
    {
        if (empty($inputParam)) {
            $this->build->setAll();

            return;
        }

        if (isset($inputParam["limit"])) {
            $this->build->setLimit($inputParam["limit"]);
            unset($inputParam["limit"]);
        }

        $this->buildBody($inputParam);
    }

    /**
     * @param array $inputParam
     * @return void
     */
    private function buildBody(array $inputParam): void
    {
        array_walk($inputParam, function ($value, $paramName) {
            if (strpos($paramName, ".")) {
                $this->buildNested($value, $paramName);

                return;
            }

            $type = ucfirst($this->map[$paramName]);
            $method = "set{$type}";

            $this->build->$method($value, $paramName);
        });
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return void
     */
    private function buildNested(string $value, string $paramName): void
    {
        $expName = explode(".", $paramName);
        $paramType = $this->map[$expName[0]][$expName[1]];

        $param = array(
            "value" => $value,
            "parentName" => $expName[0],
            "fullName" => $paramName,
            "type" => $paramType
        );

        $this->build->setNested($param);
    }
}