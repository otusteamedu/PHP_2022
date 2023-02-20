<?php


namespace Study\Cinema\Infrastructure\Service\Queue\EmailPublisher;

class EmailSendDTO
{
    private string $from;

    private string $to;

    private string $body;

    private string $title;

    private string $attachment;

    private array $payload;

    public function __construct(array $data)
    {
        $this->payload =
            [
                'from' => $data['from'],
                'to' =>$data['to'],
                'body' => $data['body'],
                'title' => $data['title'],
                'attachment' => $data['attachment'],
            ];
    }
    public function toAMQPMessage(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR);
    }

    /**
     * @return mixed|string
     */
    public function getDateFrom(): mixed
    {
        return $this->from;
    }

      /**
     * @return mixed|string
     */
    public function getDateTill(): mixed
    {
        return $this->to;
    }

    /**
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->body;
    }

}