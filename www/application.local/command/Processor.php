<?php
namespace app\command;

use app\services\RabbitmqService;
use app\services\StatementService;
use app\services\UserQueryService;
use PhpAmqpLib\Message\AMQPMessage;

class Processor {

    public function run () {
        $connection = (new RabbitmqService())->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('userQueries', false, false, false, false);

        echo "Жду сообщений. Для выхода нажмите CTRL+C\n";

        $callback = function ($msg) {
            try {
                $this->handleMessage($msg);
            } catch (\Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        };

        $channel->basic_consume('userQueries', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    private function handleMessage(AMQPMessage $msg): void {
        $id = $msg->getBody();
        echo 'Получен запрос от пользователя. Обрабатываю.'.PHP_EOL;
        $model = UserQueryService::getFromDb($id);
        //какая-то обработка
        sleep(5);
        $model->setStatus('processed');
        $service = new UserQueryService($model);
        $service->updateInDB();
    }


}
