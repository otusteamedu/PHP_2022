<?php

namespace App\Http\Controllers;

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
        return $this->addRequestToProcessing($request, $response);
    }

    public function getUser(Request $request, Response $response): Response
    {
        return $this->addRequestToProcessing($request, $response);
    }

    public function getUsers(Request $request, Response $response): Response
    {
        return $this->addRequestToProcessing($request, $response);
    }

    private function addRequestToProcessing(Request $request, Response $response): Response
    {
        $action = $request->input('action');
        $data = $this->jsonDecoder->toJson($request->input('data'));

        $requestId = $this->requestService->addRequest($action, $data);

        $response
            ->setContent(['requestId' => $requestId])
            ->setStatusCode(200);

        return $response;
    }
}
