<?php

namespace App\Controller\Admin;


use App\DTO\TaskDTO;
use App\DTO\TaskSkillsDTO;
use App\Manager\LessonManager;
use App\Manager\SkillManager;
use App\Manager\StudentManager;
use App\Manager\TaskAnswersManager;
use App\Manager\TaskManager;
use App\Manager\TaskSkillsManager;
use App\Manager\ScoreManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/admin/task')]
class TaskController extends BaseController
{
    private TaskManager $taskManager;
    private LessonManager $lessonManager;
    private SkillManager $skillManager;
    private TaskSkillsManager $taskSkillsManager;
    private TaskAnswersManager $taskAnswersManager;
    private ValidatorInterface $validator;
    private ScoreManager $scoreManager;
    private StudentManager $studentManager;


    public function __construct(TaskManager $taskManager, LessonManager $lessonManager, ValidatorInterface $validator,
                                SkillManager $skillManager,TaskSkillsManager $taskSkillsManager,
                                TaskAnswersManager $taskAnswersManager , ScoreManager $scoreManager,
                                StudentManager $studentManager

    )
    {
        $this->taskManager = $taskManager;
        $this->lessonManager = $lessonManager;
        $this->skillManager = $skillManager;
        $this->taskSkillsManager = $taskSkillsManager;
        $this->taskAnswersManager = $taskAnswersManager;
        $this->scoreManager = $scoreManager;
        $this->studentManager = $studentManager;
        $this->validator = $validator;


    }

    #[Route(path: '/{id}',  name: 'task.get_task', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getTaskAction(int $id): Response
    {
        $task = $this->taskManager->getTask($id);
        $data = [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'text' => $task->getText(),
            'course' => $task->getLesson()->getCourse(),
            'lesson' => $task->getLesson(),
            'taskSkills' => $task->getTaskSkills(),
            //'roles' => json_encode($this->getUser()->getRoles()),

        ];
        return $this->render('admin/task/show.twig', $data );

    }


    #[Route(path: '/edit/{id}',  name: 'task.get_edit_form', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function editForm(int $id): Response
    {
        $task = $this->taskManager->getTask($id);
        $data = [
            'id' => $task->getId(),
            'lessonId' => $task->getLesson()->getId(),
            'title' => $task->getTitle(),
            'text' => $task->getText(),
            'lesson' => $task->getLesson(),
            'course' => $task->getLesson()->getCourse(),
            'skills' => $this->skillManager->getSkills(0,20),
            'taskSkills' => $task->getTaskSkills(),
            'answers' => $task->getAnswers(),
            //'roles' => json_encode($this->getUser()->getRoles()),
        ];

        return $this->render('admin/task/edit.twig', $data );
    }

    #[Route(path: '/{id}',  name: 'task.update', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateTask(Request $request): Response
    {

        $taskDTO = TaskDTO::fromRequest( $request );

        $errors = $this->validator->validate( $taskDTO );
        $task = $this->taskManager->getTask($taskDTO->getId());

        $errors_logic = [];
        //по идее проверить таскскилл  и ансверс
        $skills =  $request->request->get('skillTitle');
        $percents = $request->request->get('skillPercent');


        //ансверс - не менее 5, хотя бы один коррект
        $answerText = $request->request->get('answerText');
        $answerIsCorrect = $request->request->get('answerIsCorrect');


        if (count($answerText) < TaskAnswersManager::MIN_ANSWERS_FOR_TASK)
                array_push($errors_logic, [ 'message' => sprintf("Необходимо указать ответов не меньше  %d.", TaskAnswersManager::MIN_ANSWERS_FOR_TASK) ]);

        if (is_null($answerIsCorrect) || count($answerIsCorrect) == 0)
                array_push($errors_logic, [ 'message' => sprintf("Должен быть хотя бы один правильный ответ.") ]);


        if ( count( $errors ) > 0 || (count( $errors_logic ) > 0) ) {

            $lesson = $this->lessonManager->getLesson($taskDTO->getLessonId());

            $data = [
                'id' => $taskDTO->getId(),
                'title' => $taskDTO->getTitle(),
                'text' =>  $taskDTO->getText(),
                'lesson' => $lesson,
                'course' => $lesson->getCourse(),
                'taskSkills' => $task->getTaskSkills(),
                'answers' => $task->getAnswers(),
                'skills' => $this->skillManager->getSkills(0,20),
                'errors' => $errors,
                'errors_logic' => $errors_logic,
                //'roles' => json_encode($this->getUser()->getRoles()),

            ];
            return $this->render('admin/task/edit.twig',  $data);

        } else {



            $taskId = $this->taskManager->updateTask($taskDTO->getId(),  $taskDTO->getTitle(),$taskDTO->getText(),  $taskDTO->getLessonId());

            $this->taskSkillsManager->saveOrUpdateTaskSkills($taskDTO->getId(), $skills, $percents );


            $this->taskAnswersManager->saveOrUpdateAnswers($taskDTO->getId(), $answerText, $answerIsCorrect );

            return $this->redirectToRoute('lesson.get_lesson', ['id' => $taskDTO->getLessonId()] );
        }

    }

    #[Route(path: '/create/{lessonId}',  name: 'task.get_create_form', requirements: ['lessonId' => '\d+'], methods: ['GET'])]
    public function createTaskForm(int $lessonId): Response
    {
        $lesson = $this->lessonManager->getLesson($lessonId);
        $data = [
            'lesson' => $lesson,
            'course' => $lesson->getCourse(),
            'skills' => $this->skillManager->getSkills(0,20),
        ];
        return $this->render('admin/task/create.twig', $data );
    }

    #[Route(path: '', name: 'task.create', methods: ['POST'])]
    public function saveTaskAction(Request $request): Response
    {

        $taskDTO = TaskDTO::fromRequest( $request );
        $errors = $this->validator->validate( $taskDTO );

        $errors_logic = [];
        //по идее проверить таскскис
        //id число, $percents - меньше 100
        $skills =  $request->request->get('skillTitle');
        $percents = $request->request->get('skillPercent');

       // $taskSkillsDTO = TaskSkillsDTO::


        //ансверс - не менее 5, хотя бы один коррект
        //по дто - текст
        $answerTexts = $request->request->get('answerText');
        $answerIsCorrects = $request->request->get('answerIsCorrect');


        if (count($answerTexts) < TaskAnswersManager::MIN_ANSWERS_FOR_TASK)
            array_push($errors_logic, [ 'message' => sprintf("Необходимо указать ответов не меньше  %d.", TaskAnswersManager::MIN_ANSWERS_FOR_TASK) ]);

        if (is_null($answerIsCorrects) || count($answerIsCorrects) == 0)
            array_push($errors_logic, [ 'message' => sprintf("Должен быть хотя бы один правильный ответ.") ]);


        if ( count( $errors ) > 0 || (count( $errors_logic ) > 0) ) {

            $lesson = $this->lessonManager->getLesson($taskDTO->getLessonId());
            $data = [
                'title' => $taskDTO->getTitle(),
                'text'  =>  $taskDTO->getText(),
                'lesson' => $lesson,
                'course' => $lesson->getCourse(),
                'skills' => $this->skillManager->getSkills(0,20),
                'errors' => $errors,
                'errors_logic' => $errors_logic,
                //'roles' => json_encode($this->getUser()->getRoles()),


            ];
            return $this->render('admin/task/create.twig',  $data);

        } else {


            $skills =  $request->request->get('skillTitle');
            $percents = $request->request->get('skillPercent');

            //кинуть исключение. Надо ли удалять таску, если ошибка дальше?
            $taskId = $this->taskManager->saveTask($taskDTO->getTitle(),  $taskDTO->getLessonId(), $taskDTO->getText());
            if($taskId)
                $this->taskSkillsManager->saveOrUpdateTaskSkills($taskId, $skills, $percents );
            if($taskId)
                $this->taskAnswersManager->saveOrUpdateAnswers($taskId, $answerTexts, $answerIsCorrects );
            return $this->redirectToRoute('lesson.get_lesson', ['id' => $taskDTO->getLessonId()] );
        }

        
    }

    #[Route(path: '/delete/{id}', name: 'task.delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteTaskByIdAction(int $id): Response
    {
        $task = $this->taskManager->getTask($id);
        $this->taskSkillsManager->deleteTaskSkillsByTaskId($id);
        $result = $this->taskManager->deleteTask($id);

        return $this->redirectToRoute('lesson.get_lesson', ['id' => $task->getLesson()->getId()] );
    }


    #[Route(path: '/show/{id}',  name: 'task.show_for_student', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showForStudent(int $id): Response
    {

        $task = $this->taskManager->getTask($id);
        $data = [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'text' => $task->getText(),
            'course' => $task->getLesson()->getCourse(),
            'lesson' => $task->getLesson(),
            'answers' => $task->getAnswers(),

        ];

        return $this->render('admin/task/showForStudent.twig', $data );
    }

    #[Route(path: '/saveAnswer', name: 'task.save_answer', methods: ['POST'])]
    public function saveAnswer(Request $request): Response
    {
       $errors = [];

       $taskId =  $request->request->get("taskId");
       if(!$taskId)
           array_push($errors, ['message' => 'Не указано задание']);
       $task = $this->taskManager->getTask($taskId);
       $answersFromStudent = $request->request->get("answerIsCorrect");
       if(empty($answersFromStudent)) {
           array_push($errors,  ['message' =>'Не указано  ни одного ответа. ']);

       }

       if(!empty($errors)) {

           $data = [
               'id' => $task->getId(),
               'title' => $task->getTitle(),
               'text' => $task->getText(),
               'course' => $task->getLesson()->getCourse(),
               'lesson' => $task->getLesson(),
               'answers' => $task->getAnswers(),
               'errors' => $errors,
               //'roles' => json_encode($this->getUser()->getRoles()),

           ];

           return $this->render('admin/task/showForStudent.twig', $data );
       }

        // сравнить с правильными ответами и посчитать скоре
        $correctAnswers =  $this->taskAnswersManager->getCorrectTaskAnswersByTaskId($taskId);

        $corrects = [];
        foreach ($correctAnswers as  $answer ) {
            array_push($corrects, $answer['id']);
        }

        $i = 0;
        foreach ($answersFromStudent as $key => $answerId ) {
            if(in_array($answerId, $corrects)) {
                $i++;
            }
            else {
                $i--;
            }
       }
        $score = 0;
        if($i==count($correctAnswers)){
            $score = 10;
        }

        //сохранить скоре
        $userId  =  $this->getUser()->getId();

        $student = $this->studentManager->getStudentByUserId($userId);

        $this->scoreManager->deleteScoreByTaskId($taskId, $student->getId());
        $this->scoreManager->saveScore($taskId, $student->getId() , $score);
        $data = [
            'id' =>  $task->getLesson()->getId(),
            //'roles' => json_encode($this->getUser()->getRoles()),
        ];
        return $this->redirectToRoute('lesson.get_lesson', $data );

    }
}
