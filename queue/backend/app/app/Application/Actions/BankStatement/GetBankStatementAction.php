<?php

namespace App\Application\Actions\BankStatement;

use App\Application\Actions\BankStatement\DTO\GetBankStatementResponse;
use App\Application\Contracts\GetBankStatementInterface;
use App\Application\Contracts\GetBankStatementRequestInterface;
use App\Http;
use App\Jobs\NotifyUserJob;
use App\Models\User;

class GetBankStatementAction
    implements GetBankStatementInterface
{
    private Http\Contracts\FetchBankStatementForClientInterface $fetchBankStatementForClientGateway;

    public function __construct(Http\Contracts\FetchBankStatementForClientInterface $fetchBankStatementForClientGateway)
    {
        $this->fetchBankStatementForClientGateway = $fetchBankStatementForClientGateway;
    }

    public function formatReport(array $data): string
    {
        return json_encode($data);
    }

    private function chooseReceiverCredentials(string $transferChannel, User $user): string
    {
        if ($transferChannel === 'telegram') {
            return $user->getTelegramChatId();
        } elseif ($transferChannel === 'email') {
            return $user->getEmail();
        } else {
            return '';
        }
    }

    public function get(GetBankStatementRequestInterface $request): GetBankStatementResponse
    {
        $response = $this->fetchBankStatementForClientGateway->fetchBankStatementForClient(
            new Http\Gateway\DTO\FetchBankStatementForClientRequest(
                $request->getUser()->getUserIdentifier(),
                $request->getUser()->getBankSecretToken()
            )
        );

        dispatch(new NotifyUserJob(
            $this->formatReport($response->getData()),
            $request->getTransferChannel(),
            $this->chooseReceiverCredentials($request->getTransferChannel(), $request->getUser())
        ));

        return new GetBankStatementResponse($response->getData());
    }
}
