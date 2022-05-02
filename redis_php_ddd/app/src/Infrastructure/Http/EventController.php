<?php

namespace App\Ddd\Infrastructure\Http;

use App\Ddd\Application\EventService;
use App\Ddd\ContainerFactory;
use App\Ddd\Domain\Event;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController
{
    private const EVENTS_DELETE_MESSAGE = 'События удалены';
    private const EVENT_NOT_FOUND_MESSAGE = 'Событие не найдено';
    private const EVENT_ADDED_MESSAGE = 'Событие добавлено';
    private const EVENT_NOT_ADDED_MESSAGE = 'Событие не добавлено';

    private JsonDecoder $decoder;
    private EventService $eventService;

    public function __construct()
    {
        $this->decoder = ContainerFactory::getContainer()->get(JsonDecoder::class);
        $this->eventService = ContainerFactory::getContainer()->get(EventService::class);
    }

    public function add(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());
        $event = Event::create()
            ->setId(uniqid('event', true))
            ->setName((string)$data['name'])
            ->setPriority((int)$data['priority'])
            ->setConditions(($this->decoder->toJson((array)$data['conditions'])));

        $message = $this->eventService->addEvent($event) ? self::EVENT_ADDED_MESSAGE : self::EVENT_NOT_ADDED_MESSAGE;

        return $this->createJsonResponse($response, $message);
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
