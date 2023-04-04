<?php


namespace App\Service;


use App\DTO\SaveScoreDTO;
use App\Entity\Student;
use App\Entity\Task;
use App\Manager\ScoreManager;
use Doctrine\ORM\EntityManagerInterface;

class ScoreService
{
    private ScoreManager $scoreManager;
    private EntityManagerInterface $entityManager;

    public function __construct(ScoreManager $scoreManager, EntityManagerInterface $entityManager)
    {
        $this->scoreManager = $scoreManager;
        $this->entityManager = $entityManager;

    }

    public function addRandomScore(): int
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();
        if ($students == null || $tasks == null) {
            return false;
        }
        $scoreId = $this->scoreManager->saveScore($tasks[array_rand($tasks)]->getId(), $students[array_rand($students)]->getId(), random_int(1, 10));
        if ($scoreId == null) {
           return false;
        }
        return $scoreId;
    }
    public function addScores(int $count): int
    {
        $createdScores = 0;
        for ($i = 0; $i < $count; $i++) {
            $scoreId = $this->addRandomScore();
            if ($scoreId !== null) {
                $createdScores++;
            }
        }
        return $createdScores;
    }

    public function addScore(SaveScoreDTO $saveScoreDTO): ?int
    {
        if($saveScoreDTO->getStudentId() == null && $saveScoreDTO->getTaskId() == null){
            $scoreId = $this->addRandomScore();
        }
        else {
            $scoreId = $this->scoreManager->saveScoreFromDTO($saveScoreDTO);
        }
        if ($scoreId === null)
            return false;
        return $scoreId;
    }
    public function getRandomTaskId(): ?int
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();
        if ($tasks == null) {
            return false;
        }
        return $tasks[array_rand($tasks)]->getId();
    }
    public function getRandomStudentId(): ?int
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
       if ($students == null) {
            return false;
        }
       return $students[array_rand($students)]->getId();
    }
}