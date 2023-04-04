<?php


namespace App\Service;


use App\DTO\SaveScoreDTO;
use App\Entity\Course;
use App\Entity\Skill;
use App\Entity\Student;
use App\Entity\Task;
use App\Manager\ScoreManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\LessonManager;
use App\Manager\TaskManager;
use App\Manager\TaskSkillsManager;

class DataGenerateService
{
    private ScoreManager $scoreManager;
    private LessonManager $lessonManager;
    private TaskManager $taskManager;
    private TaskSkillsManager $taskSkillsManager;
    private EntityManagerInterface $entityManager;

    public function __construct(ScoreManager $scoreManager, EntityManagerInterface $entityManager,
                                LessonManager $lessonManager,
                                TaskManager $taskManager,
                                TaskSkillsManager $taskSkillsManager
        )
    {
        $this->scoreManager = $scoreManager;
        $this->entityManager = $entityManager;
        $this->lessonManager = $lessonManager;
        $this->taskManager = $taskManager;
        $this->taskSkillsManager = $taskSkillsManager;

    }

    public function addRandomData(int $lessonCount, int $taskCount ): bool
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
        $courses  = $this->entityManager->getRepository(Course::class)->findAll();
       // $tasks = $this->entityManager->getRepository(Task::class)->findAll();
        $skills = $this->entityManager->getRepository(Skill::class)->findAll();

        foreach ($courses as $course){
            $lessonTitle = 'Lesson number  '.'for course '. $course->getId();

            for ($i = 0; $i < $lessonCount; $i++)
            {
                $lessonId = $this->lessonManager->saveLesson($lessonTitle, $course->getId());
                //print $lessonCount;
                for ($i = 0; $i < $taskCount; $i++) {

                    $taskTitle = 'Task number  '.'for course '. $course->getId().'for lesson '.$lessonId;
                    $taskId = $this->taskManager->saveTask($taskTitle, $lessonId, 'text ' . $taskTitle);
                    $student = $students[array_rand($students)];
                    $student->addCourse($course);
                    $scoreId = $this->scoreManager->saveScore($taskId, $student->getId() , random_int(1, 10));
                    foreach ($skills as $skill) {
                        $this->taskSkillsManager->saveTaskSkills($taskId, $skill->getId(), random_int(10, 80));
                    }
                }
            }
           // dump($lessonCount);
        }
        return true;

    }

}