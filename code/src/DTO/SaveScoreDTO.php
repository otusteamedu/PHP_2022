<?php


namespace App\DTO;


use App\Consumer\AddScores\Input\Message;


class SaveScoreDTO
{
    #[Assert\Type('numeric')]
    private ?int $taskId;

    #[Assert\Type('numeric')]
    private ?int $studentId;

    #[Assert\Type('numeric')]
    private ?int $score;

    public function __construct(array $data)
    {
        $this->taskId = $data['taskId'] ;
        $this->studentId = $data['studentId'] ;
        $this->score = $data['score'] ;
    }

    public static function createFromMessage(Message $message): self
    {
        return new self(
            [
                'taskId' => $message->getTaskId(),
                'studentId' => $message->getStudentId(),
                'score' => $message->getScore(),
            ]);
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }
}