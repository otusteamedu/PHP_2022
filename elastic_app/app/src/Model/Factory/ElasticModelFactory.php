<?php

namespace Elastic\App\Model\Factory;

use DI\ContainerBuilder;
use Elastic\App\Model\Channel;
use Elastic\App\Model\ElasticModel;
use Elastic\App\Model\Video;

class ElasticModelFactory
{
    private const MAP = [
        'channel' => Channel::class,
        'video' => Video::class,
    ];

    private ContainerBuilder $builder;

    public function __construct(ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function get(string $name): ElasticModel
    {
        return $this->builder->build()->get(self::MAP[$name]);
    }
}