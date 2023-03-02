<?php

namespace App\Infrastructure\Gateway\NewLK;

use App\Application\Gateway\NewLK\ChangeDealStateGatewayInterface;
use GuzzleHttp\ClientInterface;
use new\Domain\Enum\NewLK\DealState;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Клиент для смены статуса сделок в NewLK.
 */
class ChangeDealStateGateway implements ChangeDealStateGatewayInterface
{
    private ClientInterface $httpClient;
    /**
     * Префикс приложения
     */
    private string $prefix;
    /**
     * Секретный ключ
     */
    private string $secret;

    private string $path  = '/...';
    private string $baseUri;
    private LoggerInterface $logger;

    public function __construct(
        ClientInterface $httpClient,
        LoggerInterface $bankRequestsLogger,
        string $baseUri,
        string $prefix,
        string $salt
    ) {
        // <...>
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeDealState(
        string $appUuid,
        UuidInterface $bankUuid,
        DealState $state,
        string $comment = ''
    ): void {
        // <...>
    }
}
