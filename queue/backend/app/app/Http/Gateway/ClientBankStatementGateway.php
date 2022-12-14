<?php

namespace App\Http\Gateway;

use App\Http\Contracts\FetchBankStatementForClientInterface;
use App\Http\Contracts\FetchBankStatementForClientRequestInterface;
use App\Http\Gateway\DTO\FetchBankStatementForClientResponse;
use Exception;
use Symfony\Component\HttpClient\HttpClient;

class ClientBankStatementGateway
    implements FetchBankStatementForClientInterface
{
    public function fetchBankStatementForClient(FetchBankStatementForClientRequestInterface $request): FetchBankStatementForClientResponse
    {
        $httpClient = HttpClient::create();

        $httpResponse = $httpClient->request('GET', sprintf('https://swapi.dev/api/people/%d/', $request->getId()));

        if ($httpResponse->getStatusCode() !== 200) {
            throw new Exception(sprintf('Status code: %d', $httpResponse->getStatusCode()));
        }

        return new FetchBankStatementForClientResponse([
            'id' => $request->getId(),
            'data' => $httpResponse->toArray()
        ]);
    }
}
