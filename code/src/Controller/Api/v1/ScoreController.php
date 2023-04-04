<?php

namespace App\Controller\Api\v1;

use App\DTO\SendScoreDTO;
use App\Entity\Score;
use App\Manager\ScoreManager;
use App\Service\ScoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\AsyncService;


#[Route(path: '/api/v1/score')]
class ScoreController extends AbstractController
{
    private ScoreManager $scoreManager;
    private ScoreService $scoreService;
    private AsyncService $asyncService;

    public function __construct(ScoreManager $scoreManager, ScoreService $scoreService, AsyncService $asyncService)
    {
        $this->scoreManager = $scoreManager;
        $this->scoreService = $scoreService;
        $this->asyncService = $asyncService;
    }

    #[Route(path: '', methods: ['GET'])]
    public function getScoreAction(Request $request): Response
    {

        $score = $this->scoreManager->getScore();
        $code = empty($score) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['score' => array_map(static fn(Score $score) => $score->toArray(), $score)], $code);
    }

    #[Route(path: '/student/{studentId}/{lessonId}', requirements: ['studentId' => '\d+', 'lessonId' => '\d+'], methods: ['GET'])]
    public function getScoreByStudentAndLesson(int $studentId, int $lessonId): Response
    {
        $score = $this->scoreManager->getScoreByStudentAndLesson($studentId,$lessonId);
        $code = empty($score) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse(['score' => $score], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveScoreAction(Request $request): Response
    {
        $message = (new SendScoreDTO())->fromRequest($request)->toAMQPMessage();
        $result = $this->asyncService->publishToExchange(AsyncService::ADD_SCORE, $message);
        //$view = $this->view(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
      //  return $this->handleView($view);
        $code =  $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;
        return new JsonResponse(['success' => $result], $code);

    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteScoreAction(Request $request): Response
    {
        $scoreId = $request->query->get('scoreId');
        $result = $this->scoreManager->deleteScore($scoreId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteScoreByIdAction(int $id): Response
    {
        $result = $this->scoreManager->deleteScore($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateScoreAction(Request $request): Response
    {
        $scoreId = $request->query->get('scoreId');
        $taskId = $request->query->get('taskId');
        $studentId = $request->query->get('studentId');
        $scoreValue = $request->query->get('score');
        $result = $this->scoreManager->updateScore($scoreId, $taskId, $studentId, $scoreValue);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/addScores', methods: ['POST'])]
    public function addScoresAction(Request $request):Response
    {
        $count = $request->request->get('count');
        $async = $request->request->get('async');

        if ($async == 0) {
            $addedScores = $this->scoreService->addScores($count);
            $result = $addedScores == $count ? true : false;
            $view = $this->view(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            $sentMessages = 0;
            while($count--) {
               $sendScoreDTO = (new SendScoreDTO())->fromArray(['taskId' => $this->scoreService->getRandomTaskId(),
                                                                'studentId' => $this->scoreService->getRandomStudentId(),
                                                                'score' => random_int(1, 10)]);
               $message = $sendScoreDTO->toAMQPMessage();
               $result = $this->asyncService->publishToExchange(AsyncService::ADD_SCORE, $message);
               if($result ===  true){
                    $sentMessages++;
               }
            }
            $result = $sentMessages == $request->request->get('count') ? true : false;
            $view = $this->view(['success' => $result], $sentMessages === $count ? 200 : 500);
        }

        return $this->handleView($view);
    }

}