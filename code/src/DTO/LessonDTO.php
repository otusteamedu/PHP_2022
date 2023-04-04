<?php

namespace App\DTO;

use App\Entity\Lesson;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class LessonDTO
{

    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Length(    min: 3,
                        max: 100,
                        minMessage: 'Название должно быть не менее 3х символов',
                        maxMessage: 'Название должно быть не более 100 символов'
                    )]
    private string $title;

    private ?int $courseId;


    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->id = $data['id'] ?? null;
        $this->courseId= $data['courseId'] ?? null;

    }

    public static function fromEntity(Lesson $lesson): self
    {
        return new self([
            'title' => $lesson->getTitle(),
            'courseId' => $lesson->getCourse()->getId(),

        ]);
    }
    /**
     * @throws JsonException
     */
    public static function fromRequest(Request $request): self
    {

        return new self(
            [
                'id' => $request->request->get('id') ?? $request->query->get('id'),
                'title' => $request->request->get('title') ?? $request->query->get('title'),
                'courseId' => $request->request->get('courseId') ?? $request->query->get('courseId'),
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
    public function getCourseId(): string
    {
        return $this->courseId;
    }


}