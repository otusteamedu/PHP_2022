<?php

namespace App\Controller\Api\v1;

use App\Entity\Student;
use App\Service\StudentService;
use App\Manager\StudentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;




#[Route(path: '/api/v1/student')]
class StudentController extends AbstractController
{
  //

    public function __construct(private StudentService $studentService, private Environment $twig,
                                private StudentManager $studentManager


    )
    {
       // $this->studentManager = $studentManager;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getStudentsAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $students = $this->studentManager->getStudents($page ?? $this->studentManager::PAGINATION_DEFAULT_PAGE,
                                                    $perPage ?? $this->studentManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($students) ?  Response::HTTP_NO_CONTENT :  Response::HTTP_OK;

        return new JsonResponse(['students' => array_map(static fn(Student $student) => $student->toArray(), $students)], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveStudentAction(Request $request): Response
    {
        //$fullName = $request->request->get('fullName');
       // $age = $request->request->get('age');
        //$courseId = $request->request->get('userId');
        $userId = $request->request->get('userId');

        //dd($request);

        $studentId = $this->studentManager->saveStudent($userId );
        [$data, $code] = $studentId === null ?
            [['success' => false],  Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'studentId' => $studentId],  Response::HTTP_OK];

        return new JsonResponse($data, $code);
    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteStudentAction(Request $request): Response
    {
        $studentId = $request->query->get('studentId');
        $result = $this->studentManager->deleteStudent($studentId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteStudentByIdAction(int $id): Response
    {
        $result = $this->studentManager->deleteStudent($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateStudentAction(Request $request): Response
    {
        $studentId = $request->query->get('studentId');
      //  $fullName = $request->query->get('fullName');
        $result = $this->studentManager->updateStudent($studentId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
    #[Route(path: '/form', methods: ['GET'])]
    public function getSaveFormAction(): Response
    {
        $form = $this->studentService->getSaveForm();
        $content = $this->twig->render('student/form.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }

    #[Route(path: '/form', methods: ['POST'])]
    public function saveStudentFormAction(Request $request): Response
    {
        $result = $this->studentService->saveStudentFromForm($request);
        if (!empty($result['errors']))
            $content = $this->twig->render('student/errors.twig', ['errors' => $result['errors']]);
        else
            $content = $this->twig->render('student/success.twig', ['id' => $result['data']]);

        return new Response($content);

    }

    #[Route(path: '/form/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getUpdateFormAction(int $id): Response
    {
        $form = $this->studentService->getUpdateForm($id);
        if ($form === null) {
            return new JsonResponse(['message' => "Student with ID $id not found"], 404);
        }
        $content = $this->twig->render('student/form.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }

    #[Route(path: '/form/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateStudentFormAction(Request $request, int $id): Response
    {
        $result = $this->studentService->updateStudentFromForm($request, $id);
        if (!empty($result['errors']))
            $content = $this->twig->render('student/errors.twig', ['errors' => $result['errors']]);
        else  if (!empty($result['data']))
            $content = $this->twig->render('student/success.twig', ['id' => $result['data']]);
        else
            $content = $this->twig->render('student/form.twig', ['form' => $result['form']->createView(),]);
        return new Response($content);
    }

}