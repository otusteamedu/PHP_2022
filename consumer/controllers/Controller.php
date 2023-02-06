<?php
namespace app\controllers;

use app\services\RabbitmqService;
use app\services\StatementService;
use PhpAmqpLib\Message\AMQPMessage;

class Controller {

    public function run () {
        $connection = (new RabbitmqService())->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('bank_statements', false, false, false, false);

        echo "Жду сообщений. Для выхода нажмите CTRL+C\n";

        $callback = function ($msg) {
            try {
                $this->handleMessage($msg);
            } catch (\Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        };

        $channel->basic_consume('bank_statements', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    private function handleMessage(AMQPMessage $msg): void {
        $arr = unserialize($msg->getBody());
        echo 'Получен запрос на выписку с '.$arr['dateFrom'].' до '.$arr['dateTo'].' для '.$arr['email'].PHP_EOL;
        $statementService = new StatementService($arr['dateFrom'], $arr['dateTo'], $arr['email']);
        $statementService->create();
        $statementService->sendNotice();
    }


}
