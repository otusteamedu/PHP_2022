<?php

namespace Mselyatin\Queue\infrastructure\queue;

use Mselyatin\Queue\application\abstracts\QueueJobAbstract;
use Mselyatin\Queue\infrastructure\abstracts\QueueAbstract;
use Mselyatin\Queue\application\interfaces\QueueJobInterface;
use Mselyatin\Queue\application\valueObject\queue\QueueDataConnectionValueObject;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @property QueueDataConnectionValueObject $dataConnection
 *
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class RabbitQueue extends QueueAbstract
{
    /** @var AMQPStreamConnection|null  */
    private ?AMQPStreamConnection $connection = null;

    /** @var AMQPChannel|null  */
    private ?AMQPChannel $channel = null;

    /** @var array  */
    private array $queues = [];

    /**
     * @param QueueJobInterface $job
     * @param string $queue
     * @param int $delay
     * @return void
     */
    public function push(
        QueueJobInterface $job,
        string $queue,
        int $delay = 0
    ): string {
        $id = md5(uniqid('', true));
        $payload = json_encode(['id' => $id, 'body' => $job->serialize()]);

        $this->prepareQueue($queue);
        $message = new AMQPMessage($payload);
        $this->getChannelInstance()->basic_publish($message, $queue);

        return $id;
    }

    /**
     * @return AMQPStreamConnection
     */
    private function getConnectionInstance(): AMQPStreamConnection
    {
        if ($this->connection === null) {
            $this->connection = new AMQPStreamConnection(
                $this->dataConnection->getHost(),
                $this->dataConnection->getPort(),
                $this->dataConnection->getUser(),
                $this->dataConnection->getPassword(),
                $this->dataConnection->getVhost(),
                false,
                'AMQPLAIN',
                null,
                'en_US',
                $this->dataConnection->getConnectionTimeout(),
                $this->dataConnection->getConnectionWrite()
            );
        }

        return $this->connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannelInstance(): AMQPChannel
    {
        if ($this->channel === null) {
            $this->channel = $this->getConnectionInstance()->channel();
        }

        return $this->channel;
    }

    /**
     * @param string $queue
     * @return void
     */
    private function declareQueue(string $queue): void
    {
        $passive = false;
        $durable = true;
        $exclusive = false;
        $autoDelete = false;
        $this->getChannelInstance()->queue_declare($queue, $passive, $durable, $exclusive, $autoDelete);
    }

    /**
     * @param string $exchange
     * @return void
     */
    private function declareExchange(string $exchange): void
    {
        $type = 'direct';
        $passive = false;
        $durable = true;
        $autoDelete = false;
        $this->getChannelInstance()->exchange_declare($exchange, $type, $passive, $durable, $autoDelete);
    }

    /**
     * @param string $queue
     * @param string $exchange
     * @return void
     */
    private function bindQueue(string $queue, string $exchange): void
    {
        $this->getChannelInstance()->queue_bind($queue, $exchange);
    }

    /**
     * @param string $queue
     * @return void
     */
    public function prepareQueue(string $queue): void
    {
        if (!in_array($queue, $this->queues)) {
            $this->declareQueue($queue);
            $this->declareExchange($queue);
            $this->bindQueue($queue, $queue);
            $this->queues[] = $queue;
        }
    }

    /**
     * @param string $queue
     * @return void
     * @throws \Exception
     */
    public function listen(string $queue): void
    {
        try {
            $connection = $this->getConnectionInstance();
            $channel = $this->getChannelInstance();

            $this->declareQueue($queue);

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            $callback = function ($msg) {
                $body = json_decode($msg->body);
                $id = $body->id ?? null;

                echo PHP_EOL;
                var_dump('...................Start job with ID: ' . $id);
                echo PHP_EOL;
                var_dump('Result job: ');
                echo PHP_EOL;

                try {
                    $object = unserialize($body->body ?? '');
                    if ($object instanceof QueueJobAbstract) {
                        $object->execute();
                    }
                } catch (\Exception $e) {
                    var_dump('Error job: ' . $e->getMessage());
                    echo PHP_EOL;
                    //@todo Лог ошибки
                }
                $msg->ack();

                var_dump('...................Job success with ID: ' . $id);
                echo PHP_EOL;
            };

            $channel->basic_qos(null, 1, null);
            $channel->basic_consume(
                $queue,
                '',
                false,
                false,
                false,
                false,
                $callback
            );

            while ($channel->is_open()) {
                $channel->wait();
            }

            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            var_dump('Error listen queue: ' . $e->getMessage());
            die();
        }
    }
}