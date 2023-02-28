<?php

namespace App\Service;

use App\Enum\StatusEnum;
use App\Enum\UserActionEnum;
use App\Models\Request;
use App\Models\Result;
use App\RabbitMQ\Channel;
use Closure;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use PhpAmqpLib\Message\AMQPMessage;

class UserConsumer
{
    public function __construct(
        private Channel $channel,
        private JsonDecoder $jsonDecoder,
        private UserService $userService,
    ) {
    }

    public function read(string $queue): void
    {
        $this->channel
            ->connect()
            ->open($queue)
            ->consume($queue, $this->getCallback())
            ->read();
    }

    private function getCallback(): Closure
    {
        return function (AMQPMessage $msg) {
            $message = $this->jsonDecoder->toArray($msg->body);
            $requestId = (int)$message['requestId'];

            /** @var Request $request */
            $request = Request::find($requestId);
            $data = $this->jsonDecoder->toArray($request->data);

            $result = new Result();
            $result->action = $request->action;
            $result->request_id = $request->id;

            if ($request->action === UserActionEnum::ADD_USER_ACTION) {
                $result->data = $this->jsonDecoder->toJson([
                    'userId' => $this->userService->addUser($data)
                ]);
            }

            if ($request->action === UserActionEnum::GET_USER_ACTION) {
                $result->data = $this->jsonDecoder->toJson([
                    'user' => $this->userService->getUser((int)$data['id'])->toJson()
                ]);
            }

            if ($request->action === UserActionEnum::GET_USERS_ACTION) {
                $result->data = $this->jsonDecoder->toJson([
                    'users' => $this->userService->getUsers()
                ]);
            }

            $result->save();

            $request->status = StatusEnum::COMPLETE_STATUS;
            $request->update();
        };
    }

}
