<?php

namespace Nikolai\Php\Application\Contract;

use Nikolai\Php\Application\Dto\CreateEventRequest;
use Nikolai\Php\Application\Dto\CreateEventResponse;
use Nikolai\Php\Application\Dto\FindEventRequest;
use Nikolai\Php\Application\Dto\FindEventResponse;
use Nikolai\Php\Application\Dto\FlushResponse;

interface EventClientInterface
{
    const FLUSH_SUCCESS = 'События успешно удалены';

    public function create(CreateEventRequest $createEventRequest): CreateEventResponse;
    public function find(FindEventRequest $findEventRequest): FindEventResponse;
    public function flush(): FlushResponse;
}