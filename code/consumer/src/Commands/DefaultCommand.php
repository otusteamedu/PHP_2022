<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;



use Ppro\Hw27\Consumer\Application\Registry;
use Ppro\Hw27\Consumer\Queue\Broker;

class DefaultCommand extends Command
{
    /** Прослушиваем сообщения из очереди BankAccountStatement, формируем выписку и отправляем в очередь на отправку почты
     * @return void
     */
    public function execute()
    {
        $queueBrokerName = Registry::instance()->getConf()->get('QUEUE_BROKER');
        $queueBroker = new Broker($queueBrokerName);
        $queueBroker->getQueue()->listenChannel('BankAccountStatement',['\Ppro\Hw27\Consumer\Services\RabbitBankProcessing','bankAccountStatementProcessing']);
    }
}
