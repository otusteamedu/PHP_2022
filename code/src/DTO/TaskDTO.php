<?php
namespace App\DTO;

use App\Entity\Task;
use App\Entity\TaskSkills;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TaskDTO
{

    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $title;

    #[Assert\NotBlank]
    #[Assert\Length(max: 512)]
    public string $text;

    private ?int $courseId;

    private ?int $lessonId;


    /* for php >= 8.1
    #[Assert\All([
        new Assert\Type("App\DTO\TaskSkillsDTO")
    ])]
    #[Assert\Valid]
    */
    /**
     * @Assert\All({
     *    @Assert\Type("App\DTO\TaskSkillsDTO")
     * })
     * @Assert\Valid
     */
    public array $skills;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->text = $data['text'] ?? '';
        $this->skills = $data['skills'] ?? [];
        $this->lessonId = $data['lessonId'] ?? null;
    }

    public static function fromEntity(Task $task): self
    {
        return new self([
            'title' => $task->getTitle(),
            'text' => $task->getText(),
            'skills' => array_map(
                static function (TaskSkills $taskSkills) {
                    return new TaskSkillsDTO([
                        'id' => $taskSkills->getId(),
                        'percent' => $taskSkills->getPercent(),
                        'skillId' => $taskSkills->getSkill()->getId(),
                        'skillTitle' => $taskSkills->getSkill()->getTitle(),
                    ]);
                },
                $task->getTaskSkills()
            ),
        ]);
    }

    public static function fromRequest(Request $request): self
    {

        return new self(
            [
                'id' => $request->request->get('id') ?? $request->query->get('id'),
                'title' => $request->request->get('title') ?? $request->query->get('title'),
                'text' => $request->request->get('text') ?? $request->query->get('text'),
                'lessonId' => $request->request->get('lessonId') ?? $request->query->get('lessonId'),
            ]
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getLessonId(): ?int
    {
        return $this->lessonId;
    }
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }
}