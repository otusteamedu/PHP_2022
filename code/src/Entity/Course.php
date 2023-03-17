<?php

namespace App\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CourseRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


#[ORM\Table(name: 'course')]
#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Course
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $title;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: 'Lesson')]
    private Collection $lessons;

    /*
    #[ORM\ManyToMany(targetEntity: 'Student', mappedBy: 'courses')]
    private Collection $students;
*/

    #[ORM\OneToMany(targetEntity: 'StudentCourse', mappedBy: 'course')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private Collection $studentCourses;



    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;


    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->studentCourses = new ArrayCollection();
        //$this->students = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getLessons(): Collection
    {
        return $this->lessons;
    }
    public function addLesson(Lesson $lesson): void
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lesson->add($lesson);
            $lesson->setCourse($this);
        }
    }
    /*
    public function addStudent(Student $student): void
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }
    }
   public function getStudents(): Collection
   {
        return $this->students;
   }
    */
   public function getCreatedAt(): DateTime {
        return $this->createdAt;
   }

    #[ORM\PrePersist]
    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'showUrl' => '/admin2/course/'.$this->getId(),
            'lessons' => array_map(static fn(Lesson $lesson) => $lesson->toArray(), $this->lessons->toArray()),
           // 'students' => array_map(static fn(Student $student) => $student->toArray(), $this->students->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}