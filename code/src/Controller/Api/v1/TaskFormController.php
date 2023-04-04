<?php

namespace App\Controller\Api\v1;

//use App\DTO\TaskDTO;
use App\Entity\Task;
//use App\Manager\TaskFormManager;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

#[Route(path: '/api/v1/task/form')]
class TaskFormController extends AbstractController
{
    public function __construct( private Environment $twig,
                                private TaskService $taskService)
    {
    }

    #[Route(path: '', methods: ['GET'])]
    public function getSaveFormAction(): Response
    {
        $form = $this->taskService->getSaveForm();
        $content = $this->twig->render('task/taskForm.twig', [
            'form' => $form->createView(),
        ]);
        return new Response($content);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveTaskFormAction(Request $request): Response
    {
        $form = $this->taskService->getSaveForm();
        $form->handleRequest($request);

        $taskId = $this->taskService->saveTaskFromForm($form);

        if ($taskId == null)
            $content = $this->twig->render('task/taskForm.twig', ['form' => $form->createView(),]);
        else
            $content = $this->twig->render('task/success.twig', ['id' => $taskId]);

        return new Response($content);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getUpdateFormAction(int $id): Response
    {
        $form = $this->taskService->getUpdateForm($id);
        if ($form === null) {
            //todo view
            return new JsonResponse(['message' => "Task with ID $id not found"], 404);
        }
        $content = $this->twig->render('task/taskForm.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateTaskFormAction(Request $request, int $id): Response
    {
        /** @var FormInterface $form */
        $form = $this->taskService->getUpdateForm($id);
        if ($form === null) {
            $content = $this->twig->render('task/error.twig',  ['errors' => "Task with ID $id not found"]);
        }
        $form->handleRequest($request);
        $taskId = $this->taskService->updateTaskFromForm($form, $id);
        if ($taskId==null)
            $content = $this->twig->render('task/taskForm.twig', ['form' => $form->createView(),]);
        else
            $content = $this->twig->render('task/success.twig', ['id' => $taskId]);
        /*else
            $content = $this->twig->render('task/taskForm.twig', ['form' => $result['form']->createView(),]);
        */
        return new Response($content);

    }

}