<?php

namespace App\Manager;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Exception\DataSourceException;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\CommonManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CourseManager implements CommonManager

{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    public function saveCourse(string $title): ?int
    {
        $course = new Course();
        $course->setTitle($title);

        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return $course->getId();
    }

    public function updateCourse(int $courseId, string $title): bool
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }
        $course->setTitle($title);
        $this->entityManager->flush();

        return true;
    }

    public function deleteCourse(int $courseId): bool
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }
        $this->entityManager->remove($course);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Course[]
     */
    public function getCourses(int $page, int $perPage): array
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);

       // return $courseRepository->getCoursesSortByTitle($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
        return $courseRepository->findAll();
    }

    /**
     * @return Course
     */
    public function getCourse(int $courseId): Course
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);

        return $courseRepository->find($courseId);
    }
    public function registerStudent(int $studentId, int $courseId)
    {
        $course = $this->entityManager->getRepository(Course::class)->find($courseId);
        $student = $this->entityManager->getRepository(Student::class)->find($studentId);
        if ($course === null || $student === null) {
            return false;
        }
        $student->addCourse($course);
        $course->addStudent($student);
        $this->entityManager->flush();

        return true;
    }

    public function getStudents(int $courseId)
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        $course->addStudents();
    }
    public function getCoursesAsArrayList(): array
    {
        return array_map(
            static fn(Course $course) => $course->toArray(),
            $this->getCourses(self::PAGINATION_DEFAULT_PAGE,self::PAGINATION_DEFAULT_PER_PAGE),
        );
    }

    public function addStudentToCourse(int $courseId, array $user_ids): bool
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }

        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);


        foreach ($user_ids as $userId){

            /** @var Student $student */
            $student = $studentRepository->findOneBy(['user' => $userId]);

            if ($student) {
                $course->addStudent($student);
                $student->addCourse($course);
            }
        }

        $this->entityManager->flush();

        return true;
    }

    public function deleteStudentFromCourse(int $courseId, int $studentId): bool
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }

        /** @var StudentRepository $studentRepository */
        $studentRepository = $this->entityManager->getRepository(Student::class);
        /** @var Student $student */
        $student = $studentRepository->find($studentId);

        $course->deleteStudent($student);
        $student->deleteCourse($course);
        $this->entityManager->flush();

        return true;
    }

    public function setTeacherToCourse(int $courseId, int $userId): bool
    {
        /** @var CourseRepository $courseRepository */
        $courseRepository = $this->entityManager->getRepository(Course::class);
        /** @var Course $course */
        $course = $courseRepository->find($courseId);
        if ($course === null) {
            return false;
        }

        /** @var TeacherRepository $teacherRepository */
        $teacherRepository = $this->entityManager->getRepository(Teacher::class);

        /** @var Teacher $teacher */
        $teacher = $teacherRepository->findOneBy(['user' => $userId]);

        if ($teacher) {
            $course->setTeacher($teacher);
            $teacher->addCourse($course);

        }



        $this->entityManager->flush();

        return true;
    }

}