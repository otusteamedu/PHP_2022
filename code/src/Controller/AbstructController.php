<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;
use Nikolai\Php\Service\Dumper;
use Nikolai\Php\Service\DumperInterface;

abstract class AbstructController
{
    protected DumperInterface $dumper;

    public function __construct(protected ElasticSearchClientInterface $elasticSearchClient) {
        $this->dumper = new Dumper();
    }
}