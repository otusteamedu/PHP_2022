<?php

namespace App\Manager;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\CommonManager;

class SkillManager implements CommonManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveSkill(string $title): ?int
    {
        $skill = new Skill();
        $skill->setTitle($title);
        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        return $skill->getId();
    }

    public function updateSkill(int $skillId, string $title): bool
    {
        /** @var SkillRepository $skillRepository */
        $skillRepository = $this->entityManager->getRepository(Skill::class);
        /** @var Skill $skill */
        $skill = $skillRepository->find($skillId);
        if ($skill === null) {
            return false;
        }
        $skill->setTitle($title);
        $this->entityManager->flush();

        return true;
    }

    public function deleteSkill(int $skillId): bool
    {
        /** @var SkillRepository $skillRepository */
        $skillRepository = $this->entityManager->getRepository(Skill::class);
        /** @var Skill $skill */
        $skill = $skillRepository->find($skillId);
        if ($skill === null) {
            return false;
        }
        $this->entityManager->remove($skill);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Skill[]
     */
    public function getSkills(int $page, int $perPage): array
    {
        /** @var SkillRepository $skillRepository */
        $skillRepository = $this->entityManager->getRepository(Skill::class);

        return $skillRepository->getSkillsSortByTitle($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
    }
    public function getSkill(int $skillId): Skill
    {
        /** @var SkillRepository $skillRepository */
        $skillRepository = $this->entityManager->getRepository(Skill::class);

        return $skillRepository->find($skillId);
    }

}