<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: 'teacher')]
#[ORM\UniqueConstraint(name: 'inx_uniq__teacher__user_id', columns: ['user_id'])]
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
#[ORM\HasLifecycleCallbacks]


class Teacher
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;


    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: 'Course')]
    private Collection $courses;


    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;


    #[ORM\OneToOne(targetEntity: 'User')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;


    public function __construct()
    {
        $this->score = new ArrayCollection();
        $this->courses = new ArrayCollection();
       // $this->studentCourses = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function addCourse(Course $course): void
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            //$course->addStudent($this);
        }
    }

    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

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

}