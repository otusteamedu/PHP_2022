<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScoreRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: 'score')]
#[ORM\Index(columns: ['student_id'], name: 'inx__score__student_id')]
#[ORM\Index(columns: ['task_id'], name: 'inx__score__task_id')]
#[ORM\Index(columns: ['student_id','task_id','created_at'], name: 'inx__score__student_id__task_id__created_at')]

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['score' => 'partial'])]
class Score
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;
/*
    #[ORM\ManyToOne(targetEntity: 'Student', inversedBy: 'courses')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private User $author;
*/

    #[ORM\Column(type: 'integer')]
    private int $score;

    #[ORM\ManyToOne(targetEntity: 'Student', inversedBy: 'score')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: 'Task', inversedBy: 'score')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;
/*
    #[ORM\ManyToOne(targetEntity: 'TaskSkills', inversedBy: 'score')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'task_id')]
    private string $taskSkills;
*/
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;


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

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'student' =>$this->student->getName(),
            'task' =>$this->task->getTitle(),
            'score' => $this->score,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}