<?php

namespace Study\Cinema\Infrastructure\HTTP\Controller;

use Study\Cinema\Application\DTO\EventCreateDTO;
use Study\Cinema\Infrastructure\Repository\EventRepository;
use Study\Cinema\Domain\Entity\Event;
use Study\Cinema\Infrastructure\Response\Response;
use Study\Cinema\Infrastructure\HTTP\Controller\RequestValidator;


class EventController
{
    private EventRepository $eventRepository;
    private Response $response;
    private RequestValidator $validator;

    public function __construct(EventRepository $eventRepository, Response $response, RequestValidator $validator){
        $this->eventRepository = $eventRepository;
        $this->response = $response;
        $this->validator = $validator;
    }

    public function create(array $request)
    {
        if(!$this->validator->validate('create', $request))
            return $this->response->sendResponse( Response::HTTP_CODE_BAD_REQUEST, implode(",", $this->validator->getErrors()));

        $dto = new EventCreateDTO();
        $dto->priority  = $request['priority'] ?? 0;
        $dto->conditions  = $request['conditions'] ?? [];

        $event = new Event();
        $event->setId(uniqid(Event::KEY));
        $event->setName($event->getId());
        $event->setPriority($dto->priority);
        $event->setConditions($dto->conditions);


        if($this->eventRepository->create($event))
        {
              $this->response->setStatusCode( Response::HTTP_CODE_BAD_REQUEST, "Событие создано." );
        }
        else {
              $this->response->setStatusCode( Response::HTTP_CODE_OK, "Не удалось создать событие." );
        }
        return $this->response->send();


    }

    public function get(array $request)
    {

        if(!$this->validator->validate('get', $request))
            return $this->response->sendResponse( Response::HTTP_CODE_BAD_REQUEST, implode(",", $this->validator->getErrors()));
        $event = $this->eventRepository->find($request);
        if($event) {
             $this->response->setStatusCode(Response::HTTP_CODE_OK, $event);
        }
        else {
             $this->response->setStatusCode(Response::HTTP_CODE_BAD_REQUEST, "Событие не найдено." );
        }
        return $this->response->send();
    }

    public function delete(array $request)
    {
        if($this->eventRepository->delete())
        {
            $this->response->setStatusCode( Response::HTTP_CODE_OK, "События удалены." );
        }
        else {
            $this->response->setStatusCode(Response::HTTP_CODE_BAD_REQUEST, "Не удалось удалить события." );
        }
        return $this->response->send();
    }
}