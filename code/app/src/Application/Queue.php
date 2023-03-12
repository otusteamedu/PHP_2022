<?php

namespace Ppro\Hw27\App\Application;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Ppro\Hw27\App\Application\Conf;
use Ppro\Hw27\App\Application\Registry;
use Ppro\Hw27\App\Entity\DtoInterface;
use Ppro\Hw27\App\Exceptions\AppException;

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

    /** Публикует сообщение в очередь
     * @param DtoInterface $data
     * @param string|null $channelName
     * @return void
     */
    public function sendMessage(DtoInterface $data, string $channelName = null): void
    {
        $this->getConnection();
        $this->getChannel($channelName);

        $msg = new AMQPMessage($data->toJson());
        $this->channel->basic_publish($msg,'',$channelName);

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
          $this->conf->get('RABBITMQ_DEFAULT_HOST'),
          $this->conf->get('RABBITMQ_DEFAULT_PORT'),
          $this->environment->get('RABBITMQ_USER'),
          $this->environment->get('RABBITMQ_PASSWORD')
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