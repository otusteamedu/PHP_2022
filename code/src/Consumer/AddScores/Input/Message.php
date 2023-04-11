<?php

namespace App\Consumer\AddScores\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\Type('numeric')]
    private ?int $taskId;

    #[Assert\Type('numeric')]
    private ?int $studentId;

    #[Assert\Type('numeric')]
    private ?int $score;

    public static function createFromQueue(string $messageBody): self
    {
        $message = json_decode($messageBody, true, 512, JSON_THROW_ON_ERROR);
        $result = new self();
        $result->taskId = $message['taskId'];
        $result->studentId = $message['studentId'];
        $result->score = $message['score'];

        return $result;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}