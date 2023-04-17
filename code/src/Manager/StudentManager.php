<?php

namespace App\Manager;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\StudentRepository;
use App\DTO\SaveStudentDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;


class StudentManager implements CommonManager

{
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function saveStudent(int $userId): ?int
    {
        /*

        $courseRepository = $this->entityManager->getRepository(Course::class);

        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }
        */
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }

        $student = new Student();
        $student->setUser($user);


        $this->entityManager->persist($student);
        $this->entityManager->flush();



        return $student->getId();
    }

    public function updateStudent(int $studentId, int $userId): bool
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);
        /** @var Student $student */
        $student = $studentRepository->find($studentId);
        if ($student === null) {
            return false;
        }
       // $student->setFullName($fullName);
      //  $student->setAge($age);
        $this->entityManager->flush();

        return true;
    }

    public function deleteStudent(int $studentId): bool
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);
        /** @var Student $student */
        $student = $studentRepository->find($studentId);
        if ($student === null) {
            return false;
        }
        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Student[]
     */
    public function getStudents(int $page, int $perPage): array
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);

        //return $studentRepository->getStudents($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
        return $studentRepository->findAll();
    }

    public function getStudentByUserLogin(string $login): Student
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);

        return $studentRepository->getStudentByUserLogin($login);
    }

    public function getStudentByUserId(int $userId): Student
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);

        return $studentRepository->findOneBy(['user' => $userId]);
    }



    public function saveStudentFromDTO(Student $student, SaveStudentDTO $saveStudentDTO): ?int
    {
      //  $student->setFullName($saveStudentDTO->fullName);
      //  $student->setAge($saveStudentDTO->age);
        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $student->getId();
    }

    public function updateStudentFromDTO(int $studentId, SaveStudentDTO $studentDTO): ?int
    {
        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);
        /** @var Student $student */
        $student = $studentRepository->find($studentId);
        if ($student === null) {
            return false;
        }

        return $this->saveStudentFromDTO($student, $studentDTO);
    }
    public function findStudent(int $studentId): ?Student
    {
        /** @var StudentRepository $studentReposotory */
        $studentReposotory = $this->entityManager->getRepository(Student::class);
        /** @var Student $student */
        $student = $studentReposotory->find($studentId);
        return $student;
    }


}