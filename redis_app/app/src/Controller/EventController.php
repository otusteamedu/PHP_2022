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

    private const EVENTS_DELETE_MESSAGE = 'События удалены';
    private const EVENT_NOT_FOUND_MESSAGE = 'Событие не найдено';

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

        return $this->createJsonResponse($response, $result);
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->eventService->deleteEvents();

        return $this->createJsonResponse($response, self::EVENTS_DELETE_MESSAGE);
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());
        $event = $this->eventService->getEvent($data);
        $result = $event ? $event->jsonSerialize() : self::EVENT_NOT_FOUND_MESSAGE;

        return $this->createJsonResponse($response, $result);
    }

    private function createJsonResponse(ResponseInterface $response, string $message): ResponseInterface
    {
        $response->getBody()->write($message);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
