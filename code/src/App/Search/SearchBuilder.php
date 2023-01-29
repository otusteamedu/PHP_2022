<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Search;

use Nikcrazy37\Hw10\Config;

class SearchBuilder
{
    const DEFAULT_LIMIT = 10000;

    /**
     * @var array
     */
    private array $query;

    public function __construct()
    {
        $this->query = array(
            "index" => Config::getOption("INDEX"),
            "body" => array(
                "sort" => array(
                    array(
                        "_score" => array(
                            "order" => "desc"
                        )
                    )
                )
            )
        );
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return void
     */
    public function setKeyword(string $value, string $paramName): void
    {
        $this->query["body"]["query"]["bool"]["must"][] = $this->getKeyword($value, $paramName);
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return void
     */
    public function setInteger(string $value, string $paramName): void
    {
        $range = $this->prepareInteger($value);

        $this->query["body"]["query"]["bool"]["filter"][]["range"][$paramName] = $range;
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return void
     */
    public function setShort(string $value, string $paramName): void
    {
        $this->setInteger($value, $paramName);
    }

    /**
     * @param array $param
     * @return void
     */
    public function setNested(array $param): void
    {
        $query = $this->prepareNested($param);

        $this->query["body"]["query"]["bool"]["must"][]["nested"] = array(
            "path" => $param["parentName"],
            "query" => array(
                "bool" => array(
                    "filter" => array(
                        $query
                    )
                )
            )
        );
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return void
     */
    public function setText(string $value, string $paramName): void
    {
        $this->query["body"]["query"]["bool"]["must"][]["match"][$paramName] = array(
            "query" => $value,
            "fuzziness" => "AUTO"
        );
    }

    /**
     * @param string $param
     * @return void
     */
    public function setLimit(string $param): void
    {
        $this->query["size"] = $param;
    }

    /**
     * @return void
     */
    public function setAll(): void
    {
        $this->query["body"]["query"]["match_all"] = (object)[];
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $this->checkLimit();

        return $this->query;
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return \array[][]
     */
    private function getKeyword(string $value, string $paramName): array
    {
        return array(
            "match" => array(
                $paramName => array(
                    "query" => $value
                )
            )
        );
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return int[][][]
     */
    private function getInteger(string $value, string $paramName): array
    {
        $range = $this->prepareInteger($value);

        return array(
            "range" => array(
                $paramName => $range
            )
        );
    }

    /**
     * @param string $value
     * @param string $paramName
     * @return int[][][]
     */
    private function getShort(string $value, string $paramName): array
    {
        return $this->getInteger($value, $paramName);
    }

    /**
     * @param string $value
     * @return array
     */
    private function prepareInteger(string $value): array
    {
        $query = array("gte" => 0);
        $exp = explode("..", $value);

        if (isset($exp[0]) && $exp[0]) $query["gte"] = $exp[0];
        if (isset($exp[1]) && $exp[1]) $query["lte"] = $exp[1];

        return $query;
    }

    /**
     * @param array $param
     * @return mixed
     */
    private function prepareNested(array $param): mixed
    {
        $type = ucfirst($param["type"]);
        $method = "get{$type}";
        return $this->$method($param["value"], $param["fullName"]);
    }

    /**
     * @return void
     */
    private function checkLimit(): void
    {
        $this->query["size"] = $this->query["size"] ?? self::DEFAULT_LIMIT;
    }
}