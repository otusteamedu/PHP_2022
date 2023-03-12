<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;

use Ppro\Hw27\Consumer\Exceptions\InvalidMailDataException;
use Ppro\Hw27\Consumer\Application\Queue;

class SendMailCommand extends Command
{
    /** Прослушиваем сообщения из очереди MailEvent, отправляем почту
     * @return void
     */
    public function execute()
    {
        try {
            $queue = new Queue();
            $queue->listenChannel('MailEvent', ['\Ppro\Hw27\Consumer\Services\BankMailer', 'sendMailProcessing']);
        } catch (\InvalidMailDataException $e) {
            //...
        }
    }
}
