<?php

declare(strict_types=1);

namespace Infrastructure\Queue\Consumers;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Exception;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class DnsRecordsConsumer
{
    /**
     * @return void
     */
    public function consume(): void
    {
        while (true) {
            $queue_name = $_ENV['QUEUE_NAME'];
            $routing_key = $_ENV['QUEUE_ROUTING_KEY'];

            $connection = new AMQPStreamConnection(
                host: $_ENV['RABBITMQ_HOST'],
                port: $_ENV['RABBITMQ_PORT'],
                user: $_ENV['RABBITMQ_USERNAME'],
                password: $_ENV['RABBITMQ_PASSWORD']
            );

            $channel = $connection->channel();

            $channel->exchange_declare(
                exchange: $_ENV['RABBITMQ_EXCHANGE'],
                type: $_ENV['RABBITMQ_EXCHANGE_TYPE'],
                passive: false,
                durable: false,
                auto_delete: false
            );

            $channel->queue_declare(
                queue: $queue_name,
                passive: false,
                durable: false,
                exclusive: false,
                auto_delete: false
            );

            $channel->queue_bind(
                queue: $queue_name,
                exchange: $_ENV['RABBITMQ_EXCHANGE'],
                routing_key: $routing_key
            );

            $channel->basic_consume(
                queue: $queue_name,
                consumer_tag: '',
                no_local: false,
                no_ack: false,
                exclusive: false,
                nowait: false,
                callback: [$this, 'receiveMessage']
            );

            while ($channel->is_open()) {
                $channel->wait();
            }

            $channel->close();
            $connection->close();
        }
    }

    /**
     * @param AMQPMessage $msg
     * @return void
     * @throws Exception
     */
    public function receiveMessage(AMQPMessage $msg): void
    {
        try {
            $data = json_decode(json: $msg->body, associative: true);

            $aaaa_records = app()->get_host_dns_records->get(host: $data['host']);

            db()->autoConnect();

            db()
                ->update(table: 'api_tasks')
                ->params(
                    params: [
                        'result' => $aaaa_records,
                        'status' => 'COMPLETED',
                        'updated_at' => CarbonImmutable::now()
                    ]
                )
                ->where(condition: 'uuid', comparator: $data['uuid'])
                ->execute();

            echo "Сообщение из очереди, размером: " . $msg->body_size . " байт получено и успешно обработно." . PHP_EOL;

            $msg->ack();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
