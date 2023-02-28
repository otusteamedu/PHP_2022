<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Redis;

use Kogarkov\Es\Core\Service\Registry;
use Predis as PR;

class Core
{
    private $client;
    private $config;

    public function __construct()
    {
        $this->config = Registry::instance()->get('config');
        $this->client = new PR\Client($this->config->get('redis_host'));
    }

    public function get(): PR\Client
    {
        return $this->client;
    }
}
