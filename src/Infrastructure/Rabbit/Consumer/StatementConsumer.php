<?php

namespace App\Infrastructure\Rabbit\Consumer;

use App\Domain\Entity\Statement;
use App\Domain\Enum\StatusEnum;
use App\Infrastructure\Rabbit\Consumer\Input\Message;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class StatementConsumer implements ConsumerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}


    public function execute(AMQPMessage $msg)
    {
        $message = Message::createFromQueue($msg->getBody());

        $repository = $this->entityManager->getRepository(Statement::class);
        $statement = $repository->findOneById($message->getId());

        if (!$statement) {
            return ConsumerInterface::MSG_REJECT;
        }

        $statement->setStatus(StatusEnum::IN_QUEUE);
        $this->entityManager->flush();

        // как будто запрашиваем данные из банка
        sleep(20);

        $statement->setStatus(StatusEnum::READY);
        $this->entityManager->flush();

        $this->entityManager->clear();
        $this->entityManager->getConnection()->close();

        return ConsumerInterface::MSG_ACK;
    }
}
