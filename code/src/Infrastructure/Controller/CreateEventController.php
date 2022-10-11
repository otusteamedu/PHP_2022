<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Dto\CreateEventRequest;
use Nikolai\Php\Application\RequestConverter\RequestConverterInterface;
use Nikolai\Php\Application\Service\CreateEventService;

class CreateEventController implements ControllerInterface
{
    public function __construct(
        private RequestConverterInterface $requestConverter,
        private CreateEventService $createEventService
    ) {}

    public function __invoke($request)
    {
        $arguments = $this->requestConverter->convert($request);
        $createEventRequest = CreateEventRequest::create($arguments['event'], $arguments['priority'], $arguments['conditions']);
        $createEventResponse = $this->createEventService->createEvent($createEventRequest);

        fwrite(STDOUT, 'Событие: ' . $createEventResponse->event . ' успешно добавлено/обновлено!' . PHP_EOL);
    }
}