<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\Otkritie;

use App\Application\Gateway\Bank\OtkritieApiGatewayInterface;
use App\Infrastructure\Serialization\Bank\Otkritie\OtkritieEncoder;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use App\Application\DTO\Bank\Otkritie\Response\Main as EnterApplicationResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OtkritieApiGateway implements OtkritieApiGatewayInterface
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
        // <...>
    }
}
