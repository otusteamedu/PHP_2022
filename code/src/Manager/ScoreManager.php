<?php

namespace App\Manager;

use App\DTO\SaveScoreDTO;
use App\Entity\Score;
use App\Entity\Task;
use App\Entity\Student;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class ScoreManager implements CommonManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveScore(int $taskId, int $studentId, int $scoreValue): ?int
    {

        $student = $this->entityManager->getRepository(Student::class)->find($studentId);
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        if ($task == null || $student == null) {
            return false;
        }
        $score = new Score();
        $score->setStudent($student);
        $score->setTask($task);
        $score->setScore($scoreValue);
        $score->setCreatedAt();
        $score->setUpdatedAt();
        $this->entityManager->persist($score);
        $this->entityManager->flush();

        return $score->getId();
    }

    public function updateScore(int $scoreId, int $taskId, int $studentId, $scoreValue): bool
    {
        $student = $this->entityManager->getRepository(Student::class)->find($studentId);
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        /** @var ScoreRepository $scoreRepository */
        $scoreRepository = $this->entityManager->getRepository(Score::class);
        /** @var Score $score */
        $score = $scoreRepository->find($scoreId);
        if ($score === null || $task == null || $student == null) {
            return false;
        }

        $score->setStudent($student);
        $score->setTask($task);
        $score->setScore($scoreValue);
        $score->setUpdatedAt();
        $this->entityManager->flush();

        return true;
    }

    public function deleteScore(int $scoreId): bool
    {
        /** @var ScoreRepository $scoreRepository */
        $scoreRepository = $this->entityManager->getRepository(Score::class);
        /** @var Score $score */
        $score = $scoreRepository->find($scoreId);
        if ($score === null) {
            return false;
        }
        $this->entityManager->remove($score);
        $this->entityManager->flush();

        return true;
    }

    public function deleteScoreByTaskId(int $taskId, int $studentId): bool
    {
        /** @var ScoreRepository $scoreRepository */
        $scoreRepository = $this->entityManager->getRepository(Score::class);
        /** @var Score $score */
        $score = $scoreRepository->findOneBy([ 'task'=>$taskId, 'student' => $studentId]);
        if ($score === null) {
            return false;
        }
        $this->entityManager->remove($score);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Score[]
     */
    public function getScore(): array
    {
        /** @var ScoreRepository $scoreRepository */
        $scoreRepository = $this->entityManager->getRepository(Score::class);

        return $scoreRepository->findAll();
    }

    public function getScoreByStudentAndLesson(int $studentId, int $lessonId): array
    {
        /** @var ScoreRepository $scoreRepository */
        $scoreRepository = $this->entityManager->getRepository(Score::class);

        return $scoreRepository->getScoreByOneLesson($studentId, $lessonId);
    }

    public function saveScoreFromDTO(SaveScoreDTO $saveScoreDTO): ?int
    {
        $student = $this->entityManager->getRepository(Student::class)->find($saveScoreDTO->getStudentId());
        $task = $this->entityManager->getRepository(Task::class)->find($saveScoreDTO->getTaskId());
        if ($task == null || $student == null) {
            return false;
        }
        $score = new Score();
        $score->setStudent($student);
        $score->setTask($task);
        $score->setScore($saveScoreDTO->getScore());
        $this->entityManager->persist($score);
        $this->entityManager->flush();

        return $score->getId();
    }

    public function getScoreGroupByLessons(array $students, int $courseId,  DateTime $startDate = null, DateTime $finishDate = null)
    {
        return $this->entityManager->getRepository(Score::class)->getScoreGroupByLesson($students,$courseId, $startDate, $finishDate );
    }

    public function getScoreGroupByLessonsAndSkill(array $students, int $courseId,  DateTime $startDate = null, DateTime $finishDate = null)
    {
        return $this->entityManager->getRepository(Score::class)->getScoreGroupByLessonAndSkill($students,$courseId, $startDate, $finishDate );
    }

    public function getScoreGroupByLessonsAndSkillAndTask(array $students, int $courseId,  DateTime $startDate = null, DateTime $finishDate = null)
    {
        return $this->entityManager->getRepository(Score::class)->getScoreGroupByLessonAndSkillAndTask($students,$courseId, $startDate, $finishDate );
    }




}