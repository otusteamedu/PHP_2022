<?php

namespace App\DTO;

use App\Entity\TaskSkills;
use Symfony\Component\Validator\Constraints as Assert;

class TaskSkillsDTO
{
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\LessThanOrEqual(value: 100)]

    public int $percent;

    public ?int $skillId = null;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 32)]
    public string $skillTitle;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->percent = $data['percent'] ?? 0;
        $this->skillId = $data['skillId'] ?? null;
        $this->skillTitle = $data['skillTitle'] ?? '';
    }

    public static function fromEntity(TaskSkills $taskSkills): self
    {
        return new self([
            'id' => $taskSkills->getId(),
            'percent' => $taskSkills->getPercent(),
            'skillId' => $taskSkills->getSkill()->getId(),
            'skillTitle' => $taskSkills->getSkill()->getTitle(),
        ]);
    }
}