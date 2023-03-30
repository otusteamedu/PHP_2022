<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Service;

use Kogarkov\Es\Model\ResponseModel;

class Response
{
    private $data = '';

    public function setData(array $data): object
    {
        $this->data = $data;
        return $this;
    }

    public function asJson(): object
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->data = json_encode($this->data);
        return $this;
    }

    public function isOk(): void
    {
        print_r($this->data);
    }

    public function isBad(): void
    {
        http_response_code(400);
        print_r($this->data);
    }
}
