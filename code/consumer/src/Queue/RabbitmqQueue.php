<?php

namespace Ppro\Hw27\Consumer\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Ppro\Hw27\App\Application\Conf;
use Ppro\Hw27\App\Application\Registry;
use Ppro\Hw27\Consumer\Entity\DtoInterface;
use Ppro\Hw27\App\Exceptions\AppException;
use Ppro\Hw27\App\Queue\Config\RabbitmqConfig;

class RabbitmqQueue implements QueueInterface
{
    private ?AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    private array $conf = [];

    public function setConfig(array $config)
    {
        $this->conf = $config;
    }

    /** Прослушиваем канал $channelName, с возможностью ограничения кол-ва получаемых сообщений
     * @param string|null $channelName
     * @param array $callback
     * @param int $maxMsgCountByStep
     * @return void
     */
    public function listenChannel(string $channelName = null, array $callback = [], int $maxMsgCountByStep = 0)
    {
        $this->getConnection();
        $this->getChannel($channelName);
        $msgCount = 0;

        $this->channel->basic_consume($channelName, '', false, true, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
            //ограничиваем при необходимости кол-во обрабатываемых сообщений в процессе
            if($maxMsgCountByStep && $msgCount++ > $maxMsgCountByStep)
                break;
        }

        $this->closeConnection();
    }

    /** Отправляем сообщение в канал с именем $channelName
     * @param \Ppro\Hw27\Consumer\Entity\DtoInterface $data
     * @param string|null $channelName
     * @return void
     */
    public function sendMessage(DtoInterface $data, string $channelName = null): void
    {
        $this->getConnection();
        $this->getChannel($channelName);

        $msg = new AMQPMessage($data->toJson());
        $this->channel->basic_publish($msg, '', $channelName);

        $this->closeConnection();
    }

    /**
     * @param string $channelName
     * @return void
     */
    private function getChannel(string $channelName = 'default')
    {
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($channelName, false, false, false, false);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function getConnection()
    {
        $this->connection = new AMQPStreamConnection(
          $this->conf['RABBITMQ_HOST'],
          $this->conf['RABBITMQ_PORT'],
          $this->conf['RABBITMQ_USER'],
          $this->conf['RABBITMQ_PASSWORD']
        );
    }


    /**
     * @return void
     * @throws \Exception
     */
    private function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }

}