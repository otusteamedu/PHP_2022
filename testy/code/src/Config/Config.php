<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Config;


class Config
{
    /** @var string */
    private $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}