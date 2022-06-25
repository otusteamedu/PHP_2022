<?php

namespace App\Http\Controllers;

use App\Service\Publisher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;

class ReportController extends Controller
{
    public function __construct(
        private JsonDecoder $jsonDecoder,
    ) {
    }

    public function generate(Request $request, Response $response, Publisher $publisher): Response
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $message = $this->jsonDecoder->toJson([
            'header' => 'Report',
            'dateFrom' => (string)$dateFrom,
            'dateTo' => (string)$dateTo
        ]);

        $publisher->write($message, 'reports');

        $response->setContent([
            'result' => true,
            'message' => 'The request has been sent for processing',
        ]);

        $response->setStatusCode(200);

        return $response;
    }
}
