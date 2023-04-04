<?php

namespace App\Controller\Admin;


use App\DTO\TaskDTO;
use App\Manager\LessonManager;
use App\Manager\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/admin/task')]
class TaskController extends AbstractController
{
    private TaskManager $taskManager;
    private LessonManager $lessonManager;
    private ValidatorInterface $validator;


    public function __construct(TaskManager $taskManager, LessonManager $lessonManager, ValidatorInterface $validator)
    {
        $this->taskManager = $taskManager;
        $this->lessonManager = $lessonManager;
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

        ];
        return $this->render('admin/task/edit.twig', $data );
    }

    #[Route(path: '/{id}',  name: 'task.update', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateTask(Request $request): Response
    {

       /* $title = $request->request->get('title');
        $text = $request->request->get('text');
        $id = $request->request->get('id');
        $lessonId = $request->request->get('lessonId');

        $this->taskManager->updateTask($id, $title, $text,  $lessonId);

        return $this->redirectToRoute('lesson.get_lesson', ['id' => $lessonId] );

*/
        $taskDTO = TaskDTO::fromRequest( $request );
        $errors = $this->validator->validate( $taskDTO );

        if (count( $errors ) > 0) {

            $lesson = $this->lessonManager->getLesson($taskDTO->getLessonId());
            $data = [
                'id' => $taskDTO->getId(),
                'title' => $taskDTO->getTitle(),
                'text' =>  $taskDTO->getText(),
                'lesson' => $lesson,
                'course' => $lesson->getCourse(),
                'errors' => $errors


            ];
            return $this->render('admin/task/edit.twig',  $data);

        } else {

            $taskId = $this->taskManager->updateTask($taskDTO->getId(),  $taskDTO->getTitle(),$taskDTO->getText(),  $taskDTO->getLessonId());
            return $this->redirectToRoute('lesson.get_lesson', ['id' => $taskDTO->getLessonId()] );
        }



    }


    #[Route(path: '/create/{lessonId}',  name: 'task.get_create_form', requirements: ['lessonId' => '\d+'], methods: ['GET'])]
    public function createTaskForm(int $lessonId): Response
    {
        $lesson = $this->lessonManager->getLesson($lessonId);
        $data = [
            'lesson' => $lesson,
            'course' => $lesson->getCourse()
        ];
        return $this->render('admin/task/create.twig', $data );
    }

    #[Route(path: '', name: 'task.create', methods: ['POST'])]
    public function saveTaskAction(Request $request): Response
    {

        $taskDTO = TaskDTO::fromRequest( $request );
        $errors = $this->validator->validate( $taskDTO );

        if (count( $errors ) > 0) {

            $lesson = $this->lessonManager->getLesson($taskDTO->getLessonId());
            $data = [
                'title' => $taskDTO->getTitle(),
                'text'  =>  $taskDTO->getText(),
                'lesson' => $lesson,
                'course' => $lesson->getCourse(),
                'errors' => $errors

            ];
            return $this->render('admin/task/create.twig',  $data);

        } else {

            $taskId = $this->taskManager->saveTask($taskDTO->getTitle(),  $taskDTO->getLessonId(), $taskDTO->getText());
            return $this->redirectToRoute('lesson.get_lesson', ['id' => $taskDTO->getLessonId()] );
        }
        
        
    }

    #[Route(path: '/delete/{id}', name: 'task.delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteTaskByIdAction(int $id): Response
    {
        $task = $this->taskManager->getTask($id);
        $result = $this->taskManager->deleteTask($id);

        return $this->redirectToRoute('lesson.get_lesson', ['id' => $task->getLesson()->getId()] );
    }
}
