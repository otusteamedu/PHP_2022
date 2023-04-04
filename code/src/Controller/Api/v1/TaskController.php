<?php

namespace App\Controller\Api\v1;

use App\Entity\Task;
use App\Manager\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use FOS\RestBundle\Controller\AbstractFOSRestController;
//use FOS\RestBundle\Controller\Annotations as Rest;

#[Route(path: '/api/v1/task')]
class TaskController extends AbstractController
{
    private TaskManager $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getTasksAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $tasks = $this->taskManager->getTasks($page ?? $this->taskManager::PAGINATION_DEFAULT_PAGE,
                                                    $perPage ?? $this->taskManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($tasks) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(
            ['tasks' => array_map(static fn(Task $task) => $task->toArray(), $tasks),
             'count' => count($tasks)
            ], $code);

        return new JsonResponse(
            ['tasks' => 'getted'
            ], 200);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveTaskAction(Request $request): Response
    {
        $title = $request->request->get('title');
        $lessonId = $request->request->get('lessonId');
        $text = $request->request->get('text');

        $taskId = $this->taskManager->saveTask($title, $lessonId, $text);
        [$data, $code] = $taskId === false ?
            [['success' => false, 'taskId' => 0], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'taskId' => $taskId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteTaskAction(Request $request): Response
    {
        $taskId = $request->query->get('taskId');
        $result = $this->taskManager->deleteTask($taskId);

        return new JsonResponse(['success' => $result], $result ?Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteTaskByIdAction(int $id): Response
    {
        $result = $this->taskManager->deleteTask($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateTaskAction(Request $request): Response
    {
        $taskId = $request->request->get('taskId');
        $title = $request->request->get('title');
        $text = $request->request->get('text');
        $lessonId = $request->request->get('lessonId');
        $result = $this->taskManager->updateTask($taskId, $title, $text,  $lessonId);

        return new JsonResponse(['success' => $result], $result ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/lesson/{lessonId}', methods: ['GET'])]
    public function getTasksByLesson(int $lessonId): Response
    {
       // $perPage = 20;//$request->query->get('perPage');
       // $page = 0; //$request->query->get('page');

        $tasks = $this->taskManager->getTasksByLesson($lessonId);
        $code = empty($tasks) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        $view = $this->view(['tasks' => $tasks], $code);
        //return new JsonResponse(['tasks' => array_map(static fn(Task $task) => $task->toArray(), $tasks)], $code);
        return $this->handleView($view);

    }

}