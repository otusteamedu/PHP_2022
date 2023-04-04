<?php

namespace App\Controller\Api\v1;

use App\Entity\Course;
use App\Manager\CourseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/course')]
class CourseController extends AbstractController
{
    private CourseManager $courseManager;

    public function __construct(CourseManager $courseManager)
    {
        $this->courseManager = $courseManager;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getCoursesAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $courses = $this->courseManager->getCourses($page ?? $this->courseManager::PAGINATION_DEFAULT_PAGE, $perPage ?? $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['courses' => array_map(static fn(Course $course) => $course->toArray(), $courses)], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveCourseAction(Request $request): Response
    {
        $title = $request->request->get('title');
        $courseId = $this->courseManager->saveCourse($title);
        [$data, $code] = $courseId === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'courseId' => $courseId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteCourseAction(Request $request): Response
    {
        $courseId = $request->query->get('courseId');
        $result = $this->courseManager->deleteCourse($courseId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteCourseByIdAction(int $id): Response
    {
        $result = $this->courseManager->deleteCourse($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateCourseAction(Request $request): Response
    {
        $courseId = $request->query->get('courseId');
        $title = $request->query->get('title');
        $result = $this->courseManager->updateCourse($courseId, $title);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/registerStudent', methods: ['POST'])]
    public function registerStudentAction(Request $request): Response
    {
        $studentId = $request->request->get('studentId');
        $courseId = $request->request->get('courseId');
        $result = $this->courseManager->registerStudent($studentId, $courseId);
        [$data, $code] = $result === null ?
            [['success' => false], Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'courseId' => $courseId], Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

}