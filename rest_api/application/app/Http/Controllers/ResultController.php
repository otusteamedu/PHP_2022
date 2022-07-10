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

    public function getResult(Request $request, Response $response, $requestId = null): Response
    {
        $status = $this->requestService->getStatus((int)$requestId);
        $data = $this->resultService->getResult((int)$requestId);

        $response
            ->setContent([
                'status' => $status,
                'data' => $data,
            ])
            ->setStatusCode(200);

        return $response;
    }
}
