<?php

namespace App\Http\Controllers;

use App\Service\RequestService;
use App\Service\ResultService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResultController extends Controller
{
    public function __construct(
        private RequestService $requestService,
        private ResultService $resultService,
    ) {
    }

    public function getResult(Request $request, Response $response): Response
    {
        $requestId = (int)$request->input('requestId');

        $status = $this->requestService->getStatus($requestId);
        $data = $this->resultService->getResult($requestId);

        $response
            ->setContent([
                'status' => $status,
                'data' => $data,
            ])
            ->setStatusCode(200);

        return $response;
    }
}
