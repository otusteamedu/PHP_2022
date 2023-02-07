<?php

namespace Study\Cinema\Infrastructure\Service\Queue\StatementPublisher;


class StatementSendDTO
{
    private string $dateFrom;

    private string $dateTill;

    private string $email;

    private array $payload;


    public function __construct(array $data)
    {
        $this->payload =
            [
                'dateFrom' => $data['dateFrom'],
                'dateTill' =>$data['dateTill'],
                'email' => $data['email'],
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
        return $this->dateFrom;
    }

      /**
     * @return mixed|string
     */
    public function getDateTill(): mixed
    {
        return $this->dateTill;
    }

    /**
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }





}