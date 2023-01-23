<?php

require_once '../vendor/autoload.php';

return [
    \Dkozlov\Otus\Repository\Interface\RepositoryInterface::class => new \Dkozlov\Otus\Repository\ElasticSearchRepository()
];