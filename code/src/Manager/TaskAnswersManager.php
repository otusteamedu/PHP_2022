<?php

namespace App\Manager;

use App\Entity\TaskAnswers;
use App\Entity\Task;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TaskAnswersManager
{

   public const  MIN_ANSWERS_FOR_TASK = 3;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveTaskAnswer(int $taskId, string $text, $isCorrect): ?int
    {


        $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        $taskAnswers = new TaskAnswers();
        $taskAnswers->setText($text);
        $taskAnswers->setTask($task);
        $taskAnswers->setIsCorrect($isCorrect);

        $this->entityManager->persist($taskAnswers);
        $this->entityManager->flush();

        return $taskAnswers->getId();
    }



    public function updateTaskAnswersByTask(int $taskId, string $text, $isCorrect): bool
    {

        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        /** @var TaskAnswersRepository $taskAnswersRepository */
        $taskAnswersRepository = $this->entityManager->getRepository(TaskAnswers::class);
        /** @var TaskAnswers $taskAnswers */
        $taskAnswers  = $taskAnswersRepository->findOneBy(['task' => $taskId]);
        if ($taskAnswers === null) {
            return false;
        }

        $taskAnswers->setText($text);
        $taskAnswers->setTask($task);
        $taskAnswers->setIsCorrect($isCorrect);
        $taskAnswers->setUpdatedAt();
        $this->entityManager->flush();

        return true;
    }



    public function deleteTaskAnswersByTaskId(int $taskId): bool
    {
        /** @var TaskAnswersRepository $taskAnswersRepository */
        $taskAnswersRepository = $this->entityManager->getRepository(TaskAnswers::class);
        /** @var TaskAnswers $taskAnswers */
        $taskAnswers = $taskAnswersRepository->findBy(['task' => $taskId]);

        if (empty($taskAnswers)) {
            return false;
        }
        foreach ($taskAnswers as $taskSkill) {
            $this->entityManager->remove($taskSkill);
        }

        $this->entityManager->flush();

        return true;
    }

    /**
     * @return TaskAnswers[]
     */
    public function getTaskAnswers(): array
    {
        /** @var TaskAnswersRepository $taskAnswersRepository */
        $taskAnswersRepository = $this->entityManager->getRepository(TaskAnswers::class);

        return $taskAnswersRepository->findAll();
    }

    public function getTaskAnswersByTask(int $taskId): ?TaskAnswers
    {

        /** @var TaskAnswersRepository $taskAnswersRepository */
        $taskAnswersRepository = $this->entityManager->getRepository(TaskAnswers::class);

        return $taskAnswersRepository->findOneBy(['task' => $taskId]);
    }
    public function getCorrectTaskAnswersByTaskId(int $taskId): array
    {

        /** @var TaskAnswersRepository $taskAnswersRepository */
        $taskAnswersRepository = $this->entityManager->getRepository(TaskAnswers::class);

       // return $taskAnswersRepository->findBy(['task' => $taskId, 'isCorrect' => true]);
        return $taskAnswersRepository->getCorrectAnswersIdsByTask( $taskId);
    }

    public function saveOrUpdateAnswers(int $taskId, array $answers, array $isCorrects)
    {
        $i = 0;
        $this->deleteTaskAnswersByTaskId($taskId);
        foreach ($answers as $answer) {

            if(empty($answers[$i]))  continue;
            $isCorrect =  false;
            if(in_array($i, $isCorrects)) $isCorrect = true;
            $this->saveTaskAnswer($taskId, $answers[$i], $isCorrect);
            $i++;
        }

    }



}