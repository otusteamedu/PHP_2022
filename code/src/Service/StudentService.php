<?php


namespace App\Service;


use App\DTO\SaveStudentDTO;
use App\Entity\Student;
use App\Manager\StudentManager;
use App\Manager\TaskFormManager;
use App\Repository\StudentRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentService
{
    public function __construct(private StudentManager $studentManager,
                                private ValidatorInterface $validator,
                                private FormFactoryInterface $formFactory
    )
    {

    }
    public function getSaveForm(): FormInterface
    {
        return $this->formFactory->createBuilder()

          //  ->add('age', IntegerType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    }
    public function getUpdateForm(int $studentId): ?FormInterface
    {

        /** @var Student $student */
        $student = $this->studentManager->findStudent($studentId);
        if ($student === null) {
            return null;
        }

        return $this->formFactory->createBuilder(FormType::class, SaveStudentDTO::fromEntity($student))

         //   ->add('age', IntegerType::class)
           ->add('submit', SubmitType::class)
            ->setMethod('PATCH')
            ->getForm();
    }

    public function saveStudentFromForm(Request $request){

        $form = $this->getSaveForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $saveStudentDTO = new SaveStudentDTO($form->getData());
            $errors =  $this->validateDTO($saveStudentDTO);
            if(!empty($errors))
                return ['errors' => $errors];

            $studentId = $this->studentManager->saveStudentFromDTO(new Student(), new SaveStudentDTO($form->getData()));
            if($studentId)
                return ['data' => $studentId];

        }

    }

    public function updateStudentFromForm(Request $request, int $id)
    {
        $form = $this->getUpdateForm($id);
        if ($form === null) {
            return ['errors' => ['message' => "Student with ID $id not found"] ];
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $errors =  $this->validateDTO($form->getData());
            if(!empty($errors))
                return ['errors' => $errors];

            $result = $this->studentManager->updateStudentFromDTO($id, $form->getData());
            return ['data' => $result];
        }
        return ['form' => $form];
    }

    public function validateDTO($dto)
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0)
            return $errors;
        else
            return [];
    }

}