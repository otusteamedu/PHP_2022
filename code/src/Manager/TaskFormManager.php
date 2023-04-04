<?php

namespace App\Manager;

use App\DTO\TaskDTO;
use App\DTO\TaskSkillsDTO;
use App\Entity\TaskSkills;
use App\Form\TaskSkillsType;
use App\Entity\Task;
use App\Repository\TaskSkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class TaskFormManager

{
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function saveTaskFromDTO(Task $task, TaskDTO $taskDTO): ?int
    {
        $task->setTitle($taskDTO->title);
        $task->setText($taskDTO->text);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        return $task->getId();
    }

    public function updateTaskFromDTO(int $taskId, TaskDTO $taskDTO): ?int
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        /** @var TaskSkillsRepository $taskSkillsRepository */
        $taskSkillsRepository = $this->entityManager->getRepository(TaskSkills::class);
        /** @var Task $task */
        $task = $taskRepository->find($taskId);
        if ($task === null) {
            return false;
        }

        foreach ($taskDTO->skills as $skillData) {

           //$taskSkillsDTO = new TaskSkillsDTO($skillData);
           /** @var TaskSkills $taskSkills */
           $taskSkills = $taskSkillsRepository->find($skillData->id);
          if ($taskSkills !== null) {
             $this->saveTaskSkillsFromDTO($taskSkills, $skillData);
          }
       }

        return $this->saveTaskFromDTO($task, $taskDTO);
    }

    public function saveTaskSkillsFromDTO(TaskSkills $taskSkills, TaskSkillsDTO $taskSkillsDTO): ?int
    {
        //$taskSkills->setSkill($taskSkillsDTO->title);
        $taskSkills->setPercent($taskSkillsDTO->percent);
        $this->entityManager->persist($taskSkills);
        $this->entityManager->flush();

        return $taskSkills->getId();
    }
    public function findTask(int $taskId): ?Task
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        /** @var Task $task */
        $task = $taskRepository->find($taskId);
        return $task;
    }


}