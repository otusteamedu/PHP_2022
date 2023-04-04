<?php

namespace App\Manager;

use App\Entity\TaskSkills;
use App\Entity\Task;
use App\Entity\Skill;
use App\Repository\TaskSkillsRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskSkillsManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveTaskSkills(int $taskId, int $skillId, $percent): ?int
    {

        $skill = $this->entityManager->getRepository(Skill::class)->find($skillId);
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        $taskSkills = new TaskSkills();
        $taskSkills->setSkill($skill);
        $taskSkills->setTask($task);
        $taskSkills->setPercent($percent);
        $taskSkills->setCreatedAt();
        $taskSkills->setUpdatedAt();
        $this->entityManager->persist($taskSkills);
        $this->entityManager->flush();

        return $taskSkills->getId();
    }

    public function updateTaskSkills(int $taskSkillsId, int $taskId, int $skillId, $percent): bool
    {
        $skill = $this->entityManager->getRepository(Skill::class)->find($skillId);
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);
        /** @var TaskSkills $taskSkills */
        $taskSkills = $taskSkillsRepository->find($taskSkillsId);
        if ($taskSkills === null) {
            return false;
        }

        $taskSkills->setSkill($skill);
        $taskSkills->setTask($task);
        $taskSkills->setPercent($percent);
        $taskSkills->setUpdatedAt();
        $this->entityManager->flush();

        return true;
    }

    public function deleteTaskSkills(int $taskSkillsId): bool
    {
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);
        /** @var TaskSkills $taskSkills */
        $taskSkills = $taskSkillsRepository->find($taskSkillsId);
        if ($taskSkills === null) {
            return false;
        }
        $this->entityManager->remove($taskSkills);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return TaskSkills[]
     */
    public function getTaskSkills(): array
    {
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);

        return $taskSkillsRepository->findAll();
    }

}