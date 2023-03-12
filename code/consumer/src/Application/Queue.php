<?php

namespace Ppro\Hw27\Consumer\Application;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Ppro\Hw27\Consumer\Application\Registry;
use Ppro\Hw27\Consumer\Entity\DtoInterface;

class Queue
{
    private Conf $environment;
    private Conf $conf;

    private ?AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    public function __construct()
    {
        $this->environment = Registry::instance()->getEnvironment();
        $this->conf = Registry::instance()->getConf();

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
     * @param DtoInterface $data
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

    private function getChannel(string $channelName = 'default')
    {
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($channelName, false, false, false, false);
    }

    private function getConnection()
    {
        $this->connection = new AMQPStreamConnection(
          $this->conf->get('RABBITMQ_DEFAULT_HOST'),
          $this->conf->get('RABBITMQ_DEFAULT_PORT'),
          $this->environment->get('RABBITMQ_USER'),
          $this->environment->get('RABBITMQ_PASSWORD')
        );
    }


    private function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }

}