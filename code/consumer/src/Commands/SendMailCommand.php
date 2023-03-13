<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;

use Ppro\Hw27\Consumer\Application\Registry;
use Ppro\Hw27\Consumer\Exceptions\InvalidMailDataException;
use Ppro\Hw27\Consumer\Queue\Broker;

class SendMailCommand extends Command
{
    /** Прослушиваем сообщения из очереди MailEvent, отправляем почту
     * @return void
     */
    public function execute()
    {
        try {
            $queueBrokerName = Registry::instance()->getConf()->get('QUEUE_BROKER');
            $queueBroker = new Broker($queueBrokerName);
            $queueBroker->getQueue()->listenChannel('MailEvent', ['\Ppro\Hw27\Consumer\Services\BankMailer', 'sendMailProcessing']);
        } catch (InvalidMailDataException $e) {
            //...
        }
    }
}
