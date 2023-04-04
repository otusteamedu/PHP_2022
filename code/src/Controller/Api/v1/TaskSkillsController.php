<?php

namespace App\Controller\Api\v1;

use App\Entity\TaskSkills;
use App\Manager\TaskSkillsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/taskSkills')]
class TaskSkillsController extends AbstractController
{
    private TaskSkillsManager $taskSkillsManager;

    public function __construct(TaskSkillsManager $taskSkillsManager)
    {
        $this->taskSkillsManager = $taskSkillsManager;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getTaskSkillsAction(Request $request): Response
    {
        $taskSkills = $this->taskSkillsManager->getTaskSkills();
        $code = empty($taskSkills) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['taskSkills' => array_map(static fn(TaskSkills $taskSkills) => $taskSkills->toArray(), $taskSkills)], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveTaskSkillsAction(Request $request): Response
    {
        $taskId = $request->request->get('taskId');
        $skillId = $request->request->get('skillId');
        $percent = $request->request->get('percent');
        $taskSkillsId = $this->taskSkillsManager->saveTaskSkills($taskId,$skillId, $percent );
        [$data, $code] = $taskSkillsId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'taskSkillsId' => $taskSkillsId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteTaskSkillsAction(Request $request): Response
    {
        $taskSkillsId = $request->query->get('taskSkillsId');
        $result = $this->taskSkillsManager->deleteTaskSkills($taskSkillsId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteTaskSkillsByIdAction(int $id): Response
    {
        $result = $this->taskSkillsManager->deleteTaskSkills($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateTaskSkillsAction(Request $request): Response
    {
        $taskSkillsId = $request->query->get('taskSkillsId');
        $taskId = $request->query->get('taskId');
        $skillId = $request->query->get('skillId');
        $percent = $request->query->get('percent');
        $result = $this->taskSkillsManager->updateTaskSkills($taskSkillsId, $taskId, $skillId, $percent);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

}