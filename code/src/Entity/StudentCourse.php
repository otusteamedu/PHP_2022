<?php

namespace App\Entity;

use App\Repository\StudentCourseRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Table(name: 'student_course')]
#[ORM\Entity(repositoryClass: StudentCourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]

class StudentCourse
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: 'Course', inversedBy: 'studentCourses')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private Course $course;

    #[ORM\ManyToOne(targetEntity: 'Student', inversedBy: 'studentCourses')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Student $student;

    private ?int $score;


    public function __construct()
    {

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int|null $score
     */
    public function setScore(?int $score): void
    {
        $this->score = $score;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'course' => $this->course->getTitle(),
            'student' => $this->student->getTitle(),

        ];
    }
}