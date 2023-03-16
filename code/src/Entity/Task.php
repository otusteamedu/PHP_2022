<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


#[ORM\Table(name: 'task')]
#[ORM\Index(columns: ['lesson_id'], name: 'inx__task__lesson_id')]
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]

#[ApiFilter(OrderFilter::class, properties: ['lesson.title'])]
class Task
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $title;

    #[ORM\Column(type: 'string', length: 512, nullable: false)]
    private string $text;

    #[ORM\ManyToOne(targetEntity: 'Lesson', inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: 'lesson_id', referencedColumnName: 'id')]
    private ?Lesson $lesson;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: 'Score')]
    private Collection $score;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: 'TaskSkills')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Collection $taskSkills;



    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;


    public function __construct()
    {
        $this->score = new ArrayCollection();
        $this->taskSkills = new ArrayCollection();
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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void {
       // $this->createdAt = new DateTime();
        $this->createdAt = DateTime::createFromFormat('U', (string)time());
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void {
        $this->updatedAt = DateTime::createFromFormat('U', (string)time());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'lesson' => isset( $this->lesson) ? $this->lesson->getTitle() : null ,
            'title' => $this->getTitle(),
            'text' => $this->getText(),
            'createdAt' => isset($this->createdAt) ? $this->createdAt->format('Y-m-d H:i:s') : '',

        ];
    }
    public function toArrayShort(): array
    {
        return [
            'title' => $this->getTitle(),
            'text' => $this->getText(),
            'lesson' => isset( $this->lesson) ? $this->lesson->getTitle() : null ,

        ];
    }
    /**
     * @return TaskSkills[]
     */
    public function getTaskSkills(): array
    {
        return $this->taskSkills->toArray();
    }
}