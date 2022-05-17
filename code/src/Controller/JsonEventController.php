<?php

namespace App\Controller;

use App\Entity\JsonEvent;
use App\Form\JsonEventType;
use App\Service\RedisService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/json/event')]
class JsonEventController extends AbstractController
{
    #[Route('/add', name: 'app_json_event_add', methods: ['GET'])]
    public function add(RedisService $redisService)
    {
        $redisService->addEvent();

        return $this->render('json_event/add.html.twig');
    }

    #[Route('/', name: 'app_json_event_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $jsonEvents = $entityManager
            ->getRepository(JsonEvent::class)
            ->findAll();

        return $this->render('json_event/index.html.twig', [
            'json_events' => $jsonEvents,
        ]);
    }

    #[Route('/new', name: 'app_json_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jsonEvent = new JsonEvent();
        $form = $this->createForm(JsonEventType::class, $jsonEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jsonEvent);
            $entityManager->flush();

            return $this->redirectToRoute('app_json_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('json_event/new.html.twig', [
            'json_event' => $jsonEvent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_json_event_show', methods: ['GET'])]
    public function show(JsonEvent $jsonEvent): Response
    {
        return $this->render('json_event/show.html.twig', [
            'json_event' => $jsonEvent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_json_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JsonEvent $jsonEvent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JsonEventType::class, $jsonEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_json_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('json_event/edit.html.twig', [
            'json_event' => $jsonEvent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_json_event_delete', methods: ['POST'])]
    public function delete(Request $request, JsonEvent $jsonEvent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jsonEvent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jsonEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_json_event_index', [], Response::HTTP_SEE_OTHER);
    }
}
