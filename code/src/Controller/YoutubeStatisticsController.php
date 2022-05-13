<?php

namespace App\Controller;

use App\Entity\YoutubeStatistics;
use App\Form\YoutubeStatisticsType;
use App\Service\ElasticSearch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * YoutubeStatisticsController
 */
#[Route('/youtube/statistics')]
class YoutubeStatisticsController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    #[Route('/get-data', name: 'app_youtube_statistics_get_data', methods: ['GET'])]
    public function getData(): JsonResponse
    {
        return ElasticSearch::search();
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/', name: 'app_youtube_statistics_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $youtubeStatistics = $entityManager
            ->getRepository(YoutubeStatistics::class)
            ->findAll();

        return $this->render('youtube_statistics/index.html.twig', [
            'youtube_statistics' => $youtubeStatistics
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/new', name: 'app_youtube_statistics_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $youtubeStatistic = new YoutubeStatistics();
        $form = $this->createForm(YoutubeStatisticsType::class, $youtubeStatistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($youtubeStatistic);
            $entityManager->flush();

            return $this->redirectToRoute('app_youtube_statistics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('youtube_statistics/new.html.twig', [
            'youtube_statistic' => $youtubeStatistic,
            'form' => $form,
        ]);
    }

    /**
     * @param YoutubeStatistics $youtubeStatistic
     * @return Response
     */
    #[Route('/{id}', name: 'app_youtube_statistics_show', methods: ['GET'])]
    public function show(YoutubeStatistics $youtubeStatistic): Response
    {
        return $this->render('youtube_statistics/show.html.twig', [
            'youtube_statistic' => $youtubeStatistic,
        ]);
    }

    /**
     * @param Request $request
     * @param YoutubeStatistics $youtubeStatistic
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/edit', name: 'app_youtube_statistics_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, YoutubeStatistics $youtubeStatistic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YoutubeStatisticsType::class, $youtubeStatistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_youtube_statistics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('youtube_statistics/edit.html.twig', [
            'youtube_statistic' => $youtubeStatistic,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param YoutubeStatistics $youtubeStatistic
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'app_youtube_statistics_delete', methods: ['POST'])]
    public function delete(Request $request, YoutubeStatistics $youtubeStatistic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$youtubeStatistic->getId(), $request->request->get('_token'))) {
            $entityManager->remove($youtubeStatistic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_youtube_statistics_index', [], Response::HTTP_SEE_OTHER);
    }
}
