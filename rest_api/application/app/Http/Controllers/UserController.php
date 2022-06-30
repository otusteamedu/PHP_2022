<?php

namespace App\Http\Controllers;

use App\Enum\UserActionEnum;
use App\Service\RequestService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;

class UserController extends Controller
{
    public function __construct(
        private RequestService $requestService,
        private JsonDecoder $jsonDecoder,
    ) {
    }

    public function addUser(Request $request, Response $response): Response
    {
        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');

        $data = $this->jsonDecoder->toJson([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
        ]);

        $requestId = $this->requestService->addRequest(UserActionEnum::ADD_USER_ACTION, $data);

        $response
            ->setContent(['requestId' => $requestId])
            ->setStatusCode(200);

        return $response;
    }

    public function getUser(Request $request, Response $response): Response
    {
        $data = $this->jsonDecoder->toJson([
            'id' => $request->input('id')
        ]);

        $requestId = $this->requestService->addRequest(UserActionEnum::GET_USER_ACTION, $data);

        $response
            ->setContent(['requestId' => $requestId])
            ->setStatusCode(200);

        return $response;
    }

    public function getUsers(Request $request, Response $response): Response
    {
        $requestId = $this->requestService->addRequest(UserActionEnum::GET_USERS_ACTION);

        $response
            ->setContent(['requestId' => $requestId])
            ->setStatusCode(200);

        return $response;
    }
}
