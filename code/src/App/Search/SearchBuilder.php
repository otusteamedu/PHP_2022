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
            "index" => Config::getOption("index"),
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
     * @param string $param
     * @return void
     */
    public function setStock(string $param): void
    {
        $this->query["body"]["query"]["bool"]["must"][]["nested"] = array(
            "path" => "stock",
            "query" => array(
                "bool" => array(
                    "must" => array(
                        array(
                            "range" => array(
                                "stock.stock" => array("gt" => $param)
                            )
                        )
                    )
                )
            )
        );
    }

    /**
     * @param string $param
     * @return void
     */
    public function setCategory(string $param): void
    {
        $this->query["body"]["query"]["bool"]["must"][]["match"]["category"]["query"] = $param;
    }

    /**
     * @param string $param
     * @return void
     */
    public function setTitle(string $param): void
    {
        $this->query["body"]["query"]["bool"]["must"][]["match"]["title"] = array(
            "query" => $param,
            "fuzziness" => "AUTO"
        );
    }

    /**
     * @param string $param
     * @return void
     */
    public function setPrice(string $param): void
    {
        $price = $this->preparePrice($param);

        $this->query["body"]["query"]["bool"]["filter"][]["range"]["price"] = $price;
    }

    /**
     * @param string $param
     * @return array
     */
    private function preparePrice(string $param): array
    {
        $price = explode("..", $param);
        if ($price[0]) $query["gt"] = $price[0];
        if ($price[1]) $query["lt"] = $price[1];

        return $query;
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
     * @return void
     */
    private function checkLimit(): void
    {
        $this->query["size"] = $this->query["size"] ?? self::DEFAULT_LIMIT;
    }
}