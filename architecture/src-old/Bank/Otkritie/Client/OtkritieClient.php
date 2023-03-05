<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Client;

use App\Bank\Otkritie\DTO\Response\Main as EnterApplicationResponse;
use App\Bank\Otkritie\Serializer\OtkritieEncoder;
use App\Entity\Bank;
use App\Event\HttpRequestSentToBank;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OtkritieClient
{
    private ClientInterface $httpClient;
    private OtkritieEncoder $otkritieEncoder;
    private LoggerInterface $logger;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ClientInterface $client,
        OtkritieEncoder $otkritieEncoder,
        LoggerInterface $bankRequestsLogger,
        EventDispatcherInterface $dispatcher
    ) {
        $this->httpClient = $client;
        $this->logger = $bankRequestsLogger;
        $this->dispatcher = $dispatcher;
        $this->otkritieEncoder = $otkritieEncoder;
    }

    /**
     * @param resource $requestFile
     * @throws ExceptionInterface|GuzzleException
     */
    public function enterApplication($requestFile): EnterApplicationResponse
    {
        $this->logger->info('Отправка заявки в ' . Bank::NAME_OTKRITIE, [
            'bank' => Bank::NAME_OTKRITIE,
            'api_method' => 'EnterApplication',
        ]);

        try {
            $response = $this->httpClient->request(
                'POST',
                'application/create',
                [
                    'body' => $requestFile,
                ]
            );
            $this->dispatcher->dispatch(new HttpRequestSentToBank(Bank::NAME_OTKRITIE, Bank::UUID_OTKRITIE, $response));
        } catch (BadResponseException $e) {
            $this->logger->info('Ошибка при отправке заявки в ' . Bank::NAME_OTKRITIE, [
                'content' => [
                    'Код ответа' => $e->getResponse()->getStatusCode(),
                    'Ответ' => $e->getResponse()->getBody()->getContents(),
                    'Ошибка' => $e->getMessage(),
                ],
                'bank' => Bank::NAME_OTKRITIE,
                'api_method' => 'EnterApplication',
            ]);
            $this->dispatcher->dispatch(new HttpRequestSentToBank(Bank::NAME_OTKRITIE, Bank::UUID_OTKRITIE, $e->getResponse()));
            throw $e;
        } catch (GuzzleException $e) {
            $this->logger->info('Ошибка при отправке заявки в ' . Bank::NAME_OTKRITIE, [
                'content' => $e->getMessage(),
                'bank' => Bank::NAME_OTKRITIE,
                'api_method' => 'EnterApplication',
            ]);
            throw $e;
        }

        $responseContent = $response->getBody()->getContents();
        $this->logger->info('Ответ на заявку от ' . Bank::NAME_OTKRITIE, [
            'content' => $responseContent,
            'bank' => Bank::NAME_OTKRITIE,
            'api_method' => 'EnterApplication',
        ]);

        try {
            $responseObject = $this->otkritieEncoder->getSerializer()->deserialize($responseContent, EnterApplicationResponse::class, 'json');
        } catch (ExceptionInterface $e) {
            $this->logger->info('Ошибка при десериализации ответа от ' . Bank::NAME_OTKRITIE, [
                'content' => [
                    'Ошибка' => $e->getMessage(),
                    'Ответ' => $$responseContent,
                ],
                'bank' => Bank::NAME_OTKRITIE,
                'api_method' => 'EnterApplication',
            ]);

            throw $e;
        }

        return $responseObject;
    }
}
