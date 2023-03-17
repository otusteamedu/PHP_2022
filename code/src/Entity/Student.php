<?php

namespace App\Entity;


use App\Repository\StudentRepository;
use App\Resolver\StudentResolver;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Resolver\StudentCollectionResolver;


#[ORM\Table(name: 'student')]
#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['name'])]

class Student
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 256, nullable: false)]
    private string $fullName;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: 'Score')]
    private Collection $score;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $age;



    #[ORM\OneToMany(targetEntity: 'StudentCourse', mappedBy: 'student')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Collection $studentCourses;

/*
    #[ORM\ManyToMany(targetEntity: 'Course', inversedBy: 'students')]
    #[ORM\JoinTable(name: 'student_course')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private ?Collection $courses;
*/

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\OneToOne(targetEntity: 'User')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    private int $totalScore;

    private ?string $courseScore = null;

    public function __construct()
    {
        $this->score = new ArrayCollection();
       // $this->courses = new ArrayCollection();
        $this->studentCourses = new ArrayCollection();

    }

     public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->fullName;
    }

    public function setName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getScore(): Collection
    {
        return $this->score;
    }

    public function addScore(Score $score): void
    {
        if (!$this->scores->contains($score)) {
            $this->scores->add($score);
            $score->setStudent($this);
        }
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }
/*
    public function addCourse(Course $course): void
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addStudent($this);
        }
    }

    public function getCourses(): Collection
    {
        return $this->courses;
    }
*/
    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

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
    public function  getTotalScore(){
        $result = 0;
        foreach($this->getScore() as $score){
            $result += $score->getScore();
        }
        return $result;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'age' => $this->age,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            //'score' => array_map(static fn(Course $course) => $course->toArray(), $this->course->toArray()),


        ];
    }

    /**
     * @return string
     */
    public function getCourseScore(): ?string
    {
        return$this->courseScore;
    }

    /**
     * @param string $courseScore
     */
    public function setCourseScore(string $courseScore): void
    {
        $this->courseScore = $courseScore;
    }


    public function getStudentCourses(): ?Collection
    {
        return $this->studentCourses;
    }

}