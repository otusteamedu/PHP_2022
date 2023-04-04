<?php


namespace App\DTO;

use JsonException;
use Symfony\Component\HttpFoundation\Request;

class SendScoreDTO
{
    private array $payload;

    public function fromRequest(Request $request): SendScoreDTO
    {
        $this->payload =
            [   'taskId' => $request->request->get('taskId') ?? $request->query->get('taskId'),
                'studentId' => $request->request->get('studentId') ?? $request->query->get('studentId'),
                'score' => $request->request->get('score') ?? $request->query->get('score'),
            ];
        return $this;
    }
    public  function fromArray(array $data): SendScoreDTO
    {
        $this->payload =
            [
                'taskId' => $data['taskId'],
                'studentId' =>$data['studentId'],
                'score' => $data['score'],
            ];
       return $this;
    }
    /**
     * @throws JsonException
     */
    public function toAMQPMessage(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR);
    }
}