<?php

namespace App\Service;

use App\Enum\StatusEnum;
use App\Models\Request;
use App\RabbitMQ\Publisher;
use Exception;

class RequestService
{
    public function __construct(
        private Publisher $publisher,
    ) {
    }

    /**
     * @throws Exception
     */
    public function addRequest(string $action, string $data): int
    {
        $request = new Request();
        $request->action = $action;
        $request->status = StatusEnum::PROCESS_STATUS;
        $request->data = $data;

        $request->save();

        //$this->publisher->write((string)$request->id, 'tasks');

        return (int)$request->id;
    }
}
