<?php

namespace App\Consumer\SendMail;

use App\Consumer\SendMail\Input\Message;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Consumer implements ConsumerInterface
{
    private EntityManagerInterface $entityManager;

    private ValidatorInterface $validator;

    private MailService $mailService;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, MailService $mailService)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->mailService = $mailService;
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

        $this->mailService->sendEmail($message->getEmail(), $message->getSubject(),  $message->getText());

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