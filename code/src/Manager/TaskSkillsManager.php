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

    public function updateTaskSkillsByTaskSkill(int $taskId, int $skillId, $percent): bool
    {
        $skill = $this->entityManager->getRepository(Skill::class)->find($skillId);
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);
        /** @var TaskSkills $taskSkills */
        $taskSkills  = $taskSkillsRepository->findOneBy(['task' => $taskId, 'skill' => $skillId ]);
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

    public function deleteTaskSkillsByTaskId(int $taskId): bool
    {
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);
        /** @var TaskSkills $taskSkills */
        $taskSkills = $taskSkillsRepository->findBy(['task' => $taskId]);

        if (empty($taskSkills)) {
            return false;
        }
        foreach ($taskSkills as $taskSkill) {
            $this->entityManager->remove($taskSkill);
        }

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

    public function getTaskSkill(int $taskId, int $skillId): ?TaskSkills
    {

        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);

        return $taskSkillsRepository->findOneBy(['task' => $taskId, 'skill' => $skillId ]);
    }


    public function saveOrUpdateTaskSkills(int $taskId, array $skills, array $percents)
    {
        $i = 0;
        foreach ($skills as $skill) {
            if(empty($skills[$i])) continue;

            if($this->getTaskSkill($taskId,$skills[$i])){
                $this->updateTaskSkillsByTaskSkill($taskId, $skills[$i], $percents[$i]);
            }
            else
                $this->saveTaskSkills($taskId, $skills[$i], $percents[$i] );
            $i++;

        }

    }

}