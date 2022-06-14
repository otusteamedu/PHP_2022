<?php

namespace App\Controller;

use App\Entity\Event;
use App\Validator\EventValidator;
use App\Service\EventService\EventService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/api/v1')]
class EventController extends AbstractController
{
    #[Route(
        path: '/events',
        name: 'get_events',
        methods: Request::METHOD_GET,
    )]
    public function getEvents(EventService $eventService): JsonResponse
    {
        $events = $eventService->get();
        return new JsonResponse([
            'success' => true,
            'code' => Response::HTTP_OK,
            'data' => array_map(fn(Event $event) => $event->toArray(), $events),
        ], Response::HTTP_OK);
    }

    #[Route(
        path: '/events',
        name: 'add_event',
        methods: Request::METHOD_POST,
    )]
    public function addEvent(
        Request        $request,
        EventService   $eventService,
        EventValidator $eventValidator,
    ): JsonResponse
    {
        $conditions = json_decode($request->get('conditions'), true);
        $validatedResult = $eventValidator->validate(
            [
                'name' => $request->get('name'),
                'event' => $request->get('event'),
                'priority' => $request->get('priority'),
                'conditions' => $conditions,
            ],
        );
        if ($validatedResult->count() > 0) {
            return new JsonResponse([
                'success' => false,
                'errors' => $eventValidator->getErrors(),
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $requestData = $eventValidator->getInputData();
        $event = new Event();
        $event->setName($requestData['name']);
        $event->setConditions($conditions);
        $event->setPriority($requestData['priority']);
        $eventService->add($event);
        return new JsonResponse([
            'success' => true,
            'code' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }

    #[Route(
        path: '/events/{id}',
        name: 'delete_event',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_DELETE],
    )]
    public function removeById(
        int          $id,
        EventService $eventService,
    ): JsonResponse
    {
        $event = $eventService->findById($id);
        if ($event instanceof Event) {
            $eventService->remove($event);
            return new JsonResponse([
                'success' => true,
                'code' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
        return new JsonResponse([
            'success' => false,
            'code' => Response::HTTP_NOT_FOUND,
        ], Response::HTTP_NOT_FOUND);
    }


    #[Route(
        path: '/search/event',
        name: 'search_event',
        methods: Request::METHOD_GET,
    )]
    public function findByParams(
        Request      $request,
        EventService $eventService,
    ): JsonResponse
    {
        $event = $eventService->findByParams($request->query->all());
        if ($event instanceof Event) {
            return new JsonResponse([
                'success' => true,
                'data' => $event->toArray(),
                'code' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
        return new JsonResponse([
            'success' => false,
            'code' => Response::HTTP_NOT_FOUND,
        ], Response::HTTP_NOT_FOUND);
    }
}
