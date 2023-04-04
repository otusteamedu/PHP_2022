<?php

namespace App\DTO;

use App\Entity\Course;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class CourseDTO
{

    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Length(    min: 3,
                        max: 50,
                        minMessage: 'Название должно быть не менее 3х символов',
                        maxMessage: 'Название должно быть не более 50ти символов'
                    )]
    private string $title;



    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->id = $data['id'] ?? null;

    }

    public static function fromEntity(Course $course): self
    {
        return new self([
            'title' => $course->getTitle(),

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
}