<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Dto\FindEventRequest;
use Nikolai\Php\Application\RequestConverter\RequestConverterInterface;
use Nikolai\Php\Application\Service\FindEventService;
use Symfony\Component\HttpFoundation\Request;

class FindController implements ControllerInterface
{
    public function __construct(
        private RequestConverterInterface $requestConverter,
        private FindEventService $findEventService
    ) {}

    public function __invoke(Request $request)
    {
        $arguments = $this->requestConverter->convert($request);
        $findEventRequest = FindEventRequest::create($arguments['conditions']);
        $findEventResponse = $this->findEventService->findEvent($findEventRequest);

        $strConditions = '';
        foreach ($findEventResponse->conditions->toArray() as $key => $value) {
            $strConditions .= $key . ' = ' . $value . '; ';
        }

        fwrite(STDOUT, 'Событие: ' . $findEventResponse->event . ' удовлетворяет заданным условиям!' . PHP_EOL);
        fwrite(STDOUT, 'Приоритет: ' . $findEventResponse->priority . PHP_EOL);
        fwrite(STDOUT, 'Условия: ' . $strConditions . PHP_EOL);
    }
}