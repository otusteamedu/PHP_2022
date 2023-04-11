<?php

namespace App\Manager;

use App\Entity\Lesson;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;


class TaskManager implements CommonManager
{
    private EntityManagerInterface $entityManager;
    private CacheItemPoolInterface $cacheItemPool;


    public function __construct(EntityManagerInterface $entityManager,  CacheItemPoolInterface $cacheItemPool)
    {
        $this->entityManager = $entityManager;
        $this->cacheItemPool = $cacheItemPool;
    }

    public function saveTask(string $title, int $lessonId, string $text): int|bool
    {
        /** @var LessonRepository $lessonRepository */
        $lesson = $this->entityManager->getRepository(Lesson::class)->find($lessonId);
         if($lesson == null) {
            return false;

        }
        if(strlen($title)==0) {
            return false;
        }
        if(strlen($text)==0) {
            return false;
        }
        $task = new Task();
        $task->setTitle($title);
        $task->setText(trim($text));
        $task->setLesson($lesson);
        $task->setCreatedAt();
        $task->setUpdatedAt();


        $this->entityManager->persist($task);
        $this->entityManager->flush();
        $this->cacheItemPool->deleteItem("tasks_by_lesson_{$lessonId}");

        return $task->getId();
    }

    public function updateTask(int $taskId, string $title, string $text, int $lessonId): bool
    {
        $lesson = $this->entityManager->getRepository(Lesson::class)->find($lessonId);
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        /** @var Task $task */
        $task = $taskRepository->find($taskId);
        if ($task === null || $lesson == null ) {
            return false;
        }
        $task->setTitle($title);
        $task->setText(trim($text));
        $task->setLesson($lesson);
        $task->setUpdatedAt();
        $this->entityManager->flush();
        $this->cacheItemPool->deleteItem("tasks_by_lesson_{$lessonId}");

        return true;
    }

    public function deleteTask(int $taskId): bool
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        /** @var Task $task */
        $task = $taskRepository->find($taskId);
        if ($task === null) {
            return false;
        }
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->cacheItemPool->deleteItem("tasks_by_lesson_{$task->getLesson()->getId()}");

        return true;
    }

    /**
     * @return Task[]
     */
    public function getTasks(int $page, int $perPage, int $lessonId): array
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);

        return $taskRepository->getTasksSortByTitle($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE, $lessonId);
    }



    public function getTasksByLesson(int $lessonId)
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);
        $tasksItem = $this->cacheItemPool->getItem("tasks_by_lesson_{$lessonId}");
        if (!$tasksItem->isHit()) {
            $tasks =  $taskRepository->getAllTasksByLesson($lessonId);
            $tasksItem->set(array_map(static fn(Task $task) => $task->toArray(), $tasks));
            $this->cacheItemPool->save($tasksItem);
        }
        return $tasksItem->get();
    }

    public function getTask(int $taskId): Task
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository(Task::class);

        return $taskRepository->find($taskId);
    }

}