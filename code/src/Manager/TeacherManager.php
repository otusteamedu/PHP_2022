<?php

namespace App\Manager;

use App\Entity\Course;
use App\Entity\Teacher;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\DTO\SaveTeacherDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;


class TeacherManager implements CommonManager

{
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function saveTeacher(int $userId): ?int
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }


        $teacher = new Teacher();
        $teacher->setUser($user);

        $this->entityManager->persist($teacher);
        $this->entityManager->flush();

        return $teacher->getId();
    }

    public function updateTeacher(int $teacherId): bool
    {
        /** @var TeacherRepository $teacherRepository */
        $teacherRepository = $this->entityManager->getRepository(Teacher::class);
        /** @var Teacher $teacher */
        $teacher = $teacherRepository->find($teacherId);
        if ($teacher === null) {
            return false;
        }
        //$teacher->setName($fullName);

        $this->entityManager->flush();

        return true;
    }

    public function deleteTeacher(int $teacherId): bool
    {
        /** @var TeacherRepository $teacherRepository */
        $teacherRepository = $this->entityManager->getRepository(Teacher::class);
        /** @var Teacher $teacher */
        $teacher = $teacherRepository->find($teacherId);
        if ($teacher === null) {
            return false;
        }
        $this->entityManager->remove($teacher);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Teacher[]
     */
    public function getTeachers(int $page, int $perPage): array
    {
        /** @var TeacherRepository $teacherRepository */
        $teacherRepository = $this->entityManager->getRepository(Teacher::class);

        return $teacherRepository->getTeachers($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
    }
/*
    public function saveTeacherFromDTO(Teacher $teacher, SaveTeacherDTO $saveTeacherDTO): ?int
    {
        $teacher->setName($saveTeacherDTO->fullName);
        $teacher->setAge($saveTeacherDTO->age);
        $this->entityManager->persist($teacher);
        $this->entityManager->flush();

        return $teacher->getId();
    }
*/
    public function updateTeacherFromDTO(int $teacherId, SaveTeacherDTO $teacherDTO): ?int
    {
        /** @var TeacherRepository $teacherRepository */
        $teacherRepository = $this->entityManager->getRepository(Teacher::class);
        /** @var Teacher $teacher */
        $teacher = $teacherRepository->find($teacherId);
        if ($teacher === null) {
            return false;
        }

        return $this->saveTeacherFromDTO($teacher, $teacherDTO);
    }
    public function findTeacher(int $teacherId): ?Teacher
    {
        /** @var TeacherRepository $teacherReposotory */
        $teacherReposotory = $this->entityManager->getRepository(Teacher::class);
        /** @var Teacher $teacher */
        $teacher = $teacherReposotory->find($teacherId);
        return $teacher;
    }


}