<?php

namespace App\Controller\Admin;


use App\DTO\LessonDTO;
use App\Manager\CourseManager;
use App\Manager\LessonManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/admin/lesson')]
class LessonController extends AbstractController
{
    private LessonManager $lessonManager;
    private CourseManager $courseManager;
    private ValidatorInterface $validator;

    public function __construct(LessonManager $lessonManager, ValidatorInterface $validator, CourseManager $courseManager )
    {
        $this->lessonManager = $lessonManager;
        $this->courseManager = $courseManager;
        $this->validator = $validator;
    }

    #[Route(path: '/{id}', name: 'lesson.get_lesson', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getLessonAction(int $id): Response
    {
        $lesson = $this->lessonManager->getLesson($id);

        $data = [
            'id' => $lesson->getId(),
            'title' => $lesson->getTitle(),
            'tasks' =>  $lesson->getTasks(),
            'course' => $lesson->getCourse()
        ];
        return $this->render('admin/lesson/show.twig', $data );

    }

    #[Route(path: '/edit/{id}', name: 'lesson.get_edit_form', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function editForm(int $id): Response
    {
        $lesson = $this->lessonManager->getLesson($id);

        $data = [
            'id' => $lesson->getId(),
            'course' => $lesson->getCourse(),
            'title' => $lesson->getTitle(),
            'tasks' =>  $lesson->getTasks(),

        ];
        return $this->render('admin/lesson/edit.twig', $data );
    }

    #[Route(path: '/{id}', name: 'lesson.update', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateLesson(Request $request): Response
    {

        $lessonDTO = LessonDTO::fromRequest( $request );
        $errors = $this->validator->validate( $lessonDTO );

        if (count( $errors ) > 0) {

            $course = $this->courseManager->getCourse($lessonDTO->getCourseId());
            return  $this->render('admin/lesson/edit.twig', ['id' => $lessonDTO->getId(), 'title' => $lessonDTO->getTitle(), 'course' => $course, 'errors' => $errors ]);

        } else {

            $this->lessonManager->updateLesson($lessonDTO->getCourseId(), $lessonDTO->getTitle(), $lessonDTO->getCourseId());
            return $this->redirectToRoute('course.get_course', ['id' => $lessonDTO->getCourseId()] );
        }
    }

    #[Route(path: '/create/{courseId}', name: 'lesson.get_create_form', requirements: ['courseId' => '\d+'], methods: ['GET'])]
    public function createLessonForm(int $courseId): Response
    {
        $course = $this->courseManager->getCourse($courseId);
        $data = [
            'course' => $course
        ];
        return $this->render('admin/lesson/create.twig', $data );
    }

    #[Route(path: '', name: 'lesson.create', methods: ['POST'])]
    public function saveLessonAction(Request $request): Response
    {
        $lessonDTO = LessonDTO::fromRequest( $request );
        $errors = $this->validator->validate( $lessonDTO );

        if (count( $errors ) > 0) {
            $course = $this->courseManager->getCourse($lessonDTO->getCourseId());
            return $this->render('admin/lesson/create.twig',  [ 'errors' => $errors, 'title' => $lessonDTO->getTitle(), 'course' => $course ]);

        } else {

            $lessonId = $this->lessonManager->saveLesson($lessonDTO->getTitle(), $lessonDTO->getCourseId());
            return $this->redirectToRoute('course.get_course', ['id' => $lessonDTO->getCourseId()] );
        }

    }

    #[Route(path: '', name: 'lesson.delete', methods: ['DELETE'])]
    public function deleteLessonAction(Request $request): Response
    {
        $lessonId = $request->query->get('lessonId');
        $result = $this->lessonManager->deleteLesson($lessonId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/delete/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteLessonByIdAction(int $id): Response
    {
        $lesson = $this->lessonManager->getLesson($id);
        $lesson->getCourse()->getId();
        $result = $this->lessonManager->deleteLesson($id);

        return $this->redirectToRoute('course.get_course', ['id' => $lesson->getCourse()->getId()] );

    }




}
