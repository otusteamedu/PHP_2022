<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Gateway\Repository\BankRepositoryInterface;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use App\Application\Exception\UnsupportedBankException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Определяет пайплайн, в который нужно отправить полученную анкету, и отправляет ее туда.
 */
class QuestionnaireBankRouter
{
    public function __construct(
        private readonly BankRepositoryInterface $bankRepository,
        private readonly MessageBusInterface $bankApplicationBus
    ) {
    }

    /**
     * @throws new\Application\Exception\UnsupportedBankException
     */
    public function send(DeliveryFullQuestionnaire $questionnaire): void
    {
        // Перед тем, как запустить обработку анкеты, удаляем лишние данные из нее, для уменьшения размера
        $questionnaire->personsBase64Html = [];
        foreach ($questionnaire->borrowerQuestionnaire->persons as $person) {
            $person->signature = '';
        }

        $bank = $this->bankRepository->find($questionnaire->bank->id);

        if (is_null($bank)) {
            throw new UnsupportedBankException(sprintf(
                'Банк %s отсутствует в БД, сделка %s',
                $questionnaire->bank->id,
                $questionnaire->dealId
            ));
        }

        $messageClassName = $bank->getInitialMessage();
        if (is_null($messageClassName)) {
            throw new UnsupportedBankException(sprintf(
                'Для банка %s не определен initial_message, сделка %s',
                $questionnaire->bank->id,
                $questionnaire->dealId
            ));
        }

        if (!class_exists($messageClassName)) {
            throw new UnsupportedBankException(sprintf(
                'Ошибка при обработке анкеты: класс %s не существует, deal %s, bank %s',
                $messageClassName,
                $questionnaire->dealId,
                $questionnaire->bank->id
            ));
        }

        /** @var new\Application\Messenger\Common\Message\BankApplicationMessageInterface $message */
        $message = new $messageClassName($questionnaire);
        $this->bankApplicationBus->dispatch($message);
    }
}
