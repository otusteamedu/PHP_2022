<?php

namespace App\Controller\Admin;

use App\DTO\CourseDTO;
use App\Entity\Student;
use App\Manager\CourseManager;
use App\Manager\UserManager;
use App\Entity\User;
use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/admin/course')]
class CourseController extends AbstractController
{
    private CourseManager $courseManager;
    private UserManager $userManager;
    private ValidatorInterface $validator;

    public function __construct(CourseManager $courseManager, UserManager $userManager,  ValidatorInterface $validator)
    {
        $this->courseManager = $courseManager;
        $this->userManager = $userManager;
        $this->validator = $validator;
    }

    #[Route(path: '', name: 'course.get_courses',  methods: ['GET'])]
    public function getCoursesAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $courses = $this->courseManager->getCourses($page ?? $this->courseManager::PAGINATION_DEFAULT_PAGE, $perPage ?? $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $data = [
            'courses' => array_map(static fn(Course $course) => $course->toArray(), $courses)
        ];

        return $this->render('admin/course/index.twig', $data );

    }

    #[Route(path: '/{id}',  name: 'course.get_course',  requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getCourseAction(int $id): Response
    {
        $course = $this->courseManager->getCourse($id);
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'lessons' =>  $course->getLessons(),
        ];

        return $this->render('admin/course/show.twig', $data );

    }

    #[Route(path: '/edit/{id}',  name: 'course.get_edit_form', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function editForm(int $id): Response
    {
        $course = $this->courseManager->getCourse($id);
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'lessons' =>  $course->getLessons(),
        ];
        return $this->render('admin/course/edit.twig', $data );

    }

    #[Route(path: '/{id}', name: 'course.update',  requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateCourse(Request $request): Response
    {

        $courseDTO = CourseDTO::fromRequest( $request );
        $errors = $this->validator->validate( $courseDTO );

        if (count( $errors ) > 0) {
             return  $this->render('admin/course/edit.twig', ['id' => $courseDTO->getId(), 'title' => $courseDTO->getTitle(), 'errors' => $errors ]);

        } else {

            $this->courseManager->updateCourse( $courseDTO->getId(), $courseDTO->getTitle() );
            return $this->redirectToRoute('course.get_courses');

        }

    }


    #[Route(path: '/create', name: 'course.get_create_form', methods: ['GET'])]
    public function createCourseForm(): Response
    {
        return $this->render('admin/course/create.twig' );
    }

    #[Route(path: '', name: 'course.create', methods: ['POST'])]
    public function saveCourseAction(Request $request): Response
    {

        $courseDTO = CourseDTO::fromRequest( $request );
        $errors = $this->validator->validate( $courseDTO );


        if (count( $errors ) > 0) {
            return $this->render('admin/course/create.twig',  [ 'errors' => $errors, 'title' => $courseDTO->getTitle() ]);

        } else {

            $courseId = $this->courseManager->saveCourse( $courseDTO->getTitle() );
            return $this->redirectToRoute('course.get_courses');
        }
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteCourseAction(Request $request): Response
    {
        $courseId = $request->query->get('courseId');
        $result = $this->courseManager->deleteCourse($courseId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/delete/{id}', name: 'course.delete',  requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteCourseByIdAction(int $id): Response
    {
        $result = $this->courseManager->deleteCourse($id);

        $courses = $this->courseManager->getCourses($page ?? $this->courseManager::PAGINATION_DEFAULT_PAGE, $perPage ?? $this->courseManager::PAGINATION_DEFAULT_PER_PAGE);
        $data = [
            'courses' => array_map(static fn(Course $course) => $course->toArray(), $courses)

        ];
        return $this->render('admin/course/index.twig', $data );
    }

    #[Route(path: '/students/{id}',  name: 'course.get_course_students',  requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getCourseStudentsAction(int $id): Response
    {

        $course = $this->courseManager->getCourse($id);
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'students' =>  array_map(static fn(Student $student) => $student->toArray(), $course->getStudents()->toArray())

        ];

        return $this->render('admin/course/showStudents.twig', $data );

    }


    #[Route(path: '/students/addForm/{id}',  name: 'course.add_students_form',  requirements: ['id' => '\d+'], methods: ['GET'])]
    public function addStudentsFormAction(int $id): Response
    {

        $users = $this->userManager->getUsersByRole(User::USER_ROLE_STUDENT, 0, 20);
        $course = $this->courseManager->getCourse($id);
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'users' => $users,
        ];

        return $this->render('admin/course/addStudents.twig', $data );

    }


    #[Route(path: '/students/add',  name: 'course.add_students', methods: ['POST'])]
    public function addStudentsAction(Request $request): Response
    {

        $id = $request->request->get('id');
        $user_ids = $request->request->get('user');
        $this->courseManager->addStudentToCourse($id,$user_ids);

        return $this->redirectToRoute('course.get_course_students', ['id' => $id] );
    }

    #[Route(path: '/students/delete/{courseId}/{userId}',  name: 'course.delete_students', methods: ['GET'])]
    public function deleteStudentAction(int $courseId, int $userId): Response
    {

        $this->courseManager->deleteStudentFromCourse($courseId,$userId);

        return $this->redirectToRoute('course.get_course_students', ['id' => $courseId] );

    }

    #[Route(path: '/teacher/setForm/{id}',  name: 'course.set_teacher_form',  requirements: ['id' => '\d+'], methods: ['GET'])]
    public function setTeacherFormAction(int $id): Response
    {

        $users = $this->userManager->getUsersByRole(User::USER_ROLE_TEACHER, 0, 20);
        $course = $this->courseManager->getCourse($id);
        $data = [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'users' => $users,
        ];

        return $this->render('admin/course/setTeacher.twig', $data );

    }
    #[Route(path: '/teacher/set',  name: 'course.set_teacher', methods: ['POST'])]
    public function setStudentsAction(Request $request): Response
    {

        $id = $request->request->get('id');
        $userId = $request->request->get('user');

        $this->courseManager->setTeacherToCourse($id,(int) $userId);

        return $this->redirectToRoute('course.get_courses' ) ;
    }


}
