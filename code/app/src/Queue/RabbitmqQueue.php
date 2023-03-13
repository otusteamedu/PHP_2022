<?php

namespace Ppro\Hw27\App\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Ppro\Hw27\App\Application\Conf;
use Ppro\Hw27\App\Application\Registry;
use Ppro\Hw27\App\Entity\DtoInterface;
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