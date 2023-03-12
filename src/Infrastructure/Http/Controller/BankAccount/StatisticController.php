<?php

namespace App\Infrastructure\Http\Controller\BankAccount;

use App\Application\Queue\BusInterface;
use App\Infrastructure\Queue\BankAccount\GenerateStatisticByDatesMessage;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StatisticController
{
    public function __construct(private readonly BusInterface $bus)
    {
    }

    public function generate(ServerRequestInterface $request): ResponseInterface
    {
        $this->bus->dispatch(new GenerateStatisticByDatesMessage(
            new \DateTimeImmutable($request->getParsedBody()['date-start']),
            new \DateTimeImmutable($request->getParsedBody()['date-end']),
        ));

        return new JsonResponse([
            'status' => 'processing',
            'msg' => 'We will notify you when the report is ready'
        ]);
    }
}