<?php

namespace App\Controller\Api\v1;

use App\Entity\Skill;
use App\Manager\SkillManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/skill')]
class SkillController extends AbstractController
{
    private SkillManager $skillManager;

    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getSkillsAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $skills = $this->skillManager->getSkills($page ?? $this->skillManager::PAGINATION_DEFAULT_PAGE,
                                                        $perPage ?? $this->skillManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($skills) ? Response::HTTP_NO_CONTENT : Response:: HTTP_OK;

        return new JsonResponse(['skills' => array_map(static fn(Skill $skill) => $skill->toArray(), $skills)], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveSkillAction(Request $request): Response
    {
        $title = $request->request->get('title');
        $skillId = $this->skillManager->saveSkill($title);
        [$data, $code] = $skillId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'skillId' => $skillId], Response:: HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteSkillAction(Request $request): Response
    {
        $skillId = $request->query->get('skillId');
        $result = $this->skillManager->deleteSkill($skillId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteSkillByIdAction(int $id): Response
    {
        $result = $this->skillManager->deleteSkill($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', requirements: ['skillId' => '\d+'], methods: ['PATCH'])]
    public function updateSkillAction(Request $request): Response
    {
        $skillId = $request->query->get('skillId');
        $title = $request->query->get('title');
        $result = $this->skillManager->updateSkill($skillId, $title);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

}