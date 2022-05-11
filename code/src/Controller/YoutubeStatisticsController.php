<?php

namespace App\Controller;

use App\Entity\YoutubeStatistics;
use App\Form\SearchStatisticsType;
use App\Form\YoutubeStatisticsType;
use App\Repository\YoutubeStatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Elastic\Elasticsearch\ClientBuilder;


#[Route('/youtube/statistics')]
class YoutubeStatisticsController extends AbstractController
{
    #[Route('/', name: 'app_youtube_statistics_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /**
         * todo - Заносити индекс по ES
         * Отримати индекс з ES
         * Виводити перелік индексів
         * Перемикати з одного ES на БД.
         */

        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();

        $params = [
            'index' => 'my_index',
            'body'  => [ 'testField' => 'abc']
        ];

        try {
            $response = $client->index($params);

            dump($response->asArray());

            $params = [
                'index' => 'my_index',
                'body'  => [
                    'query' => [
                        'match' => [
                            'testField' => 'abc'
                        ]
                    ]
                ]
            ];
            $response = $client->search($params);

            dump("Total docs: %d\n", $response['hits']['total']['value']);
            dump("Max score : %.4f\n", $response['hits']['max_score']);
            dump("Took      : %d ms\n", $response['took']);

            dump($response['hits']['hits']); // documents

        } catch (ClientResponseException $e) {
            echo $e->getMessage();
        } catch (ServerResponseException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        echo "END"; exit;

        $youtubeStatistics = $entityManager
            ->getRepository(YoutubeStatistics::class)
            ->findAll();

        $entity = new YoutubeStatistics();

        return $this->render('youtube_statistics/index.html.twig', [
            'youtube_statistics' => $youtubeStatistics
        ]);
    }

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

    #[Route('/{id}', name: 'app_youtube_statistics_show', methods: ['GET'])]
    public function show(YoutubeStatistics $youtubeStatistic): Response
    {
        return $this->render('youtube_statistics/show.html.twig', [
            'youtube_statistic' => $youtubeStatistic,
        ]);
    }

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
