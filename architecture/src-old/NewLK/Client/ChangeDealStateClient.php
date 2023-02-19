<?php

namespace App\NewLK\Client;

use App\NewLK\Enum\DealState;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Клиент для смены статуса сделок в NewLK.
 */
class ChangeDealStateClient
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

    private string $path  = '/workflow/api/state/set';
    private string $baseUri;
    private LoggerInterface $logger;

    public function __construct(
        ClientInterface $httpClient,
        LoggerInterface $bankRequestsLogger,
        string $baseUri,
        string $prefix,
        string $salt
    ) {
        $this->httpClient = $httpClient;
        $this->prefix = $prefix;
        /** @psalm-suppress PossiblyFalseOperand secret */
        $this->secret = md5(base64_decode($salt) . $prefix);
        $this->baseUri = $baseUri;
        $this->logger = $bankRequestsLogger;
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
        $formParams = [
            'bank' => $bankUuid->toString(),
            'app' => $appUuid,
            'tm' => $this->prefix,
            'key' => $this->secret,
            'state' => $state->value,
            'comment' => $comment,
        ];
        $this->logger->info('Отправка статуса в NewLK для заявки ' . $appUuid, [
            'content' => json_encode($formParams),
            'bank' => '',
            'api_method' => 'NewLK::workflow/api/state/set',
        ]);

        try {
            $this->httpClient->request('POST', $this->baseUri . $this->path, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $formParams
            ]);
        } catch (BadResponseException $e) {
            $this->logger->info('Ошибка при отправке в NewLK статуса заявки ' . $appUuid, [
                'content' => [
                    'Код ответа' => $e->getResponse()->getStatusCode(),
                    'Ответ' => $e->getResponse()->getBody()->getContents(),
                    'Ошибка' => $e->getMessage(),
                ],
                'bank' => '',
                'api_method' => 'NewLK::workflow/api/state/set',
            ]);
            throw $e;
        }
    }
}
