<?php

namespace App\Consumer\GenerateData;

use App\Consumer\GenerateData\Input\Message;
use App\Service\DataGenerateService;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class Consumer implements ConsumerInterface
{
    private EntityManagerInterface $entityManager;

    private ValidatorInterface $validator;

    private DataGenerateService $dataGenerateService;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, DataGenerateService $dataGenerateService)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->dataGenerateService = $dataGenerateService;
    }

    public function execute(AMQPMessage $msg): int
    {
       try {
            $message = Message::createFromQueue($msg->getBody());
            $errors = $this->validator->validate($message);
            if ($errors->count() > 0) {
                return $this->reject((string)$errors);
            }
        } catch (JsonException $e) {
            return $this->reject($e->getMessage());
        }

        $this->dataGenerateService->addRandomData($message->getLessonCount(), $message->getTaskCount());

        $this->entityManager->clear();
        $this->entityManager->getConnection()->close();

        return self::MSG_ACK;
    }

    private function reject(string $error): int
    {
        echo "Incorrect message: $error";
        return self::MSG_REJECT;
    }
}