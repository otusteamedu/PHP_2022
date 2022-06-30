<?php

namespace App\Service;

use App\Enum\StatusEnum;
use App\Models\Request;
use Exception;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;

class RequestService
{
    public function __construct(
        private UserPublisher $publisher,
        private JsonDecoder $jsonDecoder,
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

        $message = $this->jsonDecoder->toJson([
           'requestId' => (string)$request->id
        ]);

        $this->publisher->write($message, 'tasks');

        return (int)$request->id;
    }

    public function getStatus(int $requestId): int
    {
        /** @var Request $request */
        $request = Request::find($requestId);

        return (int)$request?->status;
    }
}
