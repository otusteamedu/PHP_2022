<?php

namespace App\Consumer\AddScores;

use App\Consumer\AddScores\Input\Message;

use App\Service\ScoreService;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DTO\SaveScoreDTO;


class Consumer implements ConsumerInterface
{
    private EntityManagerInterface $entityManager;

    private ValidatorInterface $validator;

    private ScoreService $scoreService;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, ScoreService $scoreService)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->scoreService = $scoreService;
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

        $this->scoreService->addScore(SaveScoreDTO::createFromMessage($message));

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