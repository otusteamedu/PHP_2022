<?php

namespace Redis\App\Controller;

use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Redis\App\Model\Event;
use Redis\App\Service\EventService;
use Redis\App\Trait\ContainerFactory;

class EventController
{
    use ContainerFactory;

    private JsonDecoder $decoder;
    private EventService $eventService;

    public function __construct()
    {
        $this->decoder = $this->getContainer()->get(JsonDecoder::class);
        $this->eventService = $this->getContainer()->get(EventService::class);
    }

    public function add(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());
        $event = Event::create()
            ->setId(uniqid('event', true))
            ->setName((string)$data['name'])
            ->setPriority((int)$data['priority'])
            ->setConditions(($this->decoder->toJson((array)$data['conditions'])));

        $result = $this->eventService->addEvent($event);

        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->eventService->deleteEvents();
        $response->getBody()->write('События удалены');

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());
        $event = $this->eventService->getEvent($data);
        $result = $event ? $event->jsonSerialize() : 'Событие не найдено';
        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
