<?php

declare(strict_types=1);

namespace App\Infrastructure\Api\v1\Controller;

use App\Infrastructure\Serialization\QuestionnaireEncoder;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use App\Application\UseCase\QuestionnaireBankRouter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Сюда отправляются данные по сделкам, чтобы потом перенаправить их в конкретный банк.
 */
class DealController extends AbstractController
{
    /**
     * @throws new\Application\Exception\UnsupportedBankException
     */
    public function index(
        Request $request,
        QuestionnaireEncoder $questionnaireEncoder,
        QuestionnaireBankRouter $questionnaireBankRouter,
        LoggerInterface $bankRequestsLogger
    ): JsonResponse {
        $data = $request->getContent();

        $bankRequestsLogger->info('Новая заявка', [
            'content' => $data,
            'headers' => $request->headers->all()
        ]);

        try {
            /** @var DeliveryFullQuestionnaire $questionnaire */
            $questionnaire = $questionnaireEncoder->getSerializer()->deserialize(
                $data,
                DeliveryFullQuestionnaire::class,
                'json'
            );
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ]);
        }

        $questionnaireBankRouter->send($questionnaire);

        return new JsonResponse(['message' => 'ok']);
    }
}
