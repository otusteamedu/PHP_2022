<?php

namespace App\Consumer\GenerateData\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\Type('numeric')]
    private ?int $taskCount;

    #[Assert\Type('numeric')]
    private ?int $lessonCount;

    public static function createFromQueue(string $messageBody): self
    {
        $message = json_decode($messageBody, true, 512, JSON_THROW_ON_ERROR);
        $result = new self();
        $result->taskCount = $message['taskCount'];
        $result->lessonCount = $message['lessonCount'];

        return $result;
    }

    public function getTaskCount(): int
    {
        return $this->taskCount;
    }

    public function getLessonCount(): int
    {
        return $this->lessonCount;
    }

}