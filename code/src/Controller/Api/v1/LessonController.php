<?php

namespace App\Controller\Api\v1;

use App\Manager\LessonManager;
use App\Service\LessonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




#[Route(path: '/api/v1/lesson')]
class LessonController extends AbstractController
{
    private LessonManager $lessonManager;
    private LessonService $lessonService;



    public function __construct(LessonManager $lessonManager,LessonService $lessonService)
    {
        $this->lessonManager = $lessonManager;
        $this->lessonService = $lessonService;

    }

    #[Route(path: '', methods: ['GET'])]
    public function getLessonsAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $lessons = $this->lessonManager->getLessons($page ?? $this->lessonManager::PAGINATION_DEFAULT_PAGE,
                                                          $perPage ?? $this->lessonManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($lessons) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['lessons' => $lessons], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveLessonAction(Request $request): Response
    {
        $title = $request->request->get('title');
        $courseId = $request->request->get('courseId');

        $lessonId = $this->lessonManager->saveLesson($title,$courseId);

       /// $lessonId = $this->lessonService->saveLessonAndSendMail($title, $courseId);

        [$data, $code] = $lessonId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'lessonId' => $lessonId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteLessonAction(Request $request): Response
    {
        $lessonId = $request->query->get('lessonId');
        $result = $this->lessonManager->deleteLesson($lessonId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteLessonByIdAction(int $id): Response
    {
        $result = $this->lessonManager->deleteLesson($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateLessonAction(Request $request): Response
    {
        $lessonId = $request->query->get('lessonId');
        $title = $request->query->get('title');
        $courseId = $request->query->get('courseId');
        $result = $this->lessonManager->updateLesson($lessonId, $title, $courseId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

}