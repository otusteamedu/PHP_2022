<?php

namespace Elastic\App\Model\Factory;

use Elastic\App\Model\Channel;
use Elastic\App\Model\ElasticModel;
use Elastic\App\Model\Video;
use Elastic\App\Trait\ContainerFactory;

class ElasticModelFactory
{
    use ContainerFactory;

    private const MAP = [
        'channel' => Channel::class,
        'video' => Video::class,
    ];

    public function get(string $name): ElasticModel
    {
        return $this->getContainer()->get(self::MAP[$name]);
    }
}