<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use App\Manager\CourseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin2/course')]
class CourseVueController extends AbstractController
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
        $data = [
            'courses' => $courses
        ];
        return $this->render('admin/course/index.twig', $data );

    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getCourseAction(int $id): Response
    {

        $course = $this->courseManager->getCourse($id);
       // dump($id,$course->getLessons() );
       // dump($course);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'lessons' =>  array_map(static fn(Lesson $lesson) => $lesson->toArray(), $course->getLessons()->toArray()),
        ];
        return $this->render('show.twig', ['lessons' =>  json_encode($data['lessons'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) ]);

    }

    #[Route(path: '/edit/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function editForm(int $id): Response
    {
        $course = $this->courseManager->getCourse($id);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'lessons' =>  $course->getLessons(),
        ];
        return $this->render('admin/course/edit.twig', $data );

    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateCourse(Request $request): Response
    {
        $title = $request->request->get('title');
        $id = $request->request->get('id');

        $this->courseManager->updateCourse($id, $title);
        $courses = $this->courseManager->getCourses($this->courseManager::PAGINATION_DEFAULT_PAGE, $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $data = [
            'courses' => $courses
        ];

        return $this->render('admin/course/index.twig', $data );

    }


    #[Route(path: '/create', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function createCourseForm(): Response
    {
        return $this->render('admin/course/create.twig' );
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveCourseAction(Request $request): Response
    {

        /*уже */
        $title = $request->request->get('title');
        $courseId = $this->courseManager->saveCourse($title);
        //if($courseId === null)
        $courses = $this->courseManager->getCourses($page ?? $this->courseManager::PAGINATION_DEFAULT_PAGE, $perPage ?? $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $data = [
            'courses' => $courses
        ];

        return $this->render('admin/course/index.twig', $data );
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteCourseAction(Request $request): Response
    {
        $courseId = $request->query->get('courseId');
        $result = $this->courseManager->deleteCourse($courseId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/delete/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteCourseByIdAction(int $id): Response
    {
        $result = $this->courseManager->deleteCourse($id);

        $courses = $this->courseManager->getCourses($page ?? $this->courseManager::PAGINATION_DEFAULT_PAGE, $perPage ?? $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($courses) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $data = [
            'courses' => $courses
        ];
        return $this->render('admin/course/index.twig', $data );
    }




}
