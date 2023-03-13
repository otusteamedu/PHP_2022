<?php
declare(strict_types = 1);

namespace Ppro\Hw27\App\Commands;

use Ppro\Hw27\App\Application\Registry;
use Ppro\Hw27\App\Application\Request;
use Ppro\Hw27\App\Queue\Broker;
use Ppro\Hw27\App\Entity\FormDto;
use Ppro\Hw27\App\Exceptions\AppException;
use Ppro\Hw27\App\Exceptions\BadFormRequestException;
use Ppro\Hw27\App\Validators\FormValidator;

class FormCommand extends Command
{
    /**
     * @param Request $request
     * @return void
     */
    public function execute(Request $request)
    {
        if($request->isPost()) {
            $this->formProcessing($request);
        } else
            $this->handleGet($request);
    }

    /** Получаем данные формы, отправляем в очередь, выводим результат обработки формы
     * @param Request $request
     * @return void
     */
    private function formProcessing(Request $request)
    {
        try {
            $formDTO = new FormDto(
              $request->getPostParams(),
              new FormValidator()
            );
            $formDTO->validate();

            $queueBrokerName = Registry::instance()->getConf()->get('QUEUE_BROKER');
            $queueBroker = new Broker($queueBrokerName);
            $queueBroker->getQueue()->sendMessage($formDTO, 'BankAccountStatement');

            $this->setProcessingResult($request, true,'Успешная отправка! Ожидайте отчет на '.$formDTO->email);
        }
        catch (BadFormRequestException $e) {
            $this->setProcessingResult($request, false,'Неверные значения полей');
        }
        catch (AppException $e) {
            $this->setProcessingResult($request, false,'Сервис временно недоступен');
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    private function handleGet(Request $request)
    {
        $request->setContent('title', 'Bank Statement Form');
    }

    /** Установка переменных для формирования контента
     * @param Request $request
     * @param bool $status
     * @param string $message
     * @return void
     */
    private function setProcessingResult(Request $request, bool $status, string $message = ''): void
    {
        $request->setContent('feedbackStatus', $status);
        $request->addFeedback($message);
    }
}
