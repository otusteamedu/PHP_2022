<?php

namespace App\Application\Actions\BankStatement;

use App\Application\Actions\BankStatement\DTO\GetBankStatementResponse;
use App\Application\Actions\EmailMessage\DTO\SendTextEmailMessageRequest;
use App\Application\Actions\TelegramMessage\DTO\SendTextTelegramMessageRequest;
use App\Application\Contracts\GetBankStatementInterface;
use App\Application\Contracts\GetBankStatementRequestInterface;
use App\Application\Contracts\SendTextEmailMessageInterface;
use App\Application\Contracts\SendTextTelegramMessageInterface;
use App\Http;

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
        return '';
    }

    public function get(GetBankStatementRequestInterface $request): GetBankStatementResponse
    {
        $response = $this->fetchBankStatementForClientGateway->fetchBankStatementForClient(
            new Http\Gateway\DTO\FetchBankStatementForClientRequest(
                $request->getUser()->getUserIdentifier(),
                $request->getUser()->getBankSecretToken()
            )
        );

        if ($request->getTransferChannel() === 'telegram') {
            /** @var SendTextTelegramMessageInterface $sender */
            $sender = app()->make(SendTextTelegramMessageInterface::class);
            $sender->send(new SendTextTelegramMessageRequest(
                $request->getUser()->getTelegramChatId(),
                $this->formatReport($response->getData())
            ));
        } elseif ($request->getTransferChannel() === 'email') {
            /** @var SendTextEmailMessageInterface $sender */
            $sender = app()->make(SendTextEmailMessageInterface::class);
            $sender->send(new SendTextEmailMessageRequest(
                $request->getUser()->getEmail(),
                $this->formatReport($response->getData())
            ));
        }

        return new GetBankStatementResponse();
    }
}
