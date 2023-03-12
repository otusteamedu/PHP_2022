<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;



use Ppro\Hw27\Consumer\Application\Queue;

class DefaultCommand extends Command
{
    /** Прослушиваем сообщения из очереди BankAccountStatement, формируем выписку и отправляем в очередь на отправку почты
     * @return void
     */
    public function execute()
    {
        $queue = new Queue();
        $queue->listenChannel('BankAccountStatement',['\Ppro\Hw27\Consumer\Services\RabbitBankProcessing','bankAccountStatementProcessing']);
    }
}
