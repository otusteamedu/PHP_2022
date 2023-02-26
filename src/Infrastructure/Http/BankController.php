<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http;

use DKozlov\Otus\Application;
use DKozlov\Otus\Infrastructure\Http\DTO\RequestInterface;
use DKozlov\Otus\Infrastructure\Http\DTO\ResponseInterface;
use DKozlov\Otus\Infrastructure\Queue\BankStatementQueue;
use DKozlov\Otus\Infrastructure\Queue\DTO\BankStatementMessage;

class BankController extends AbstractController
{
    public function statement(ResponseInterface $response, RequestInterface $request): void
    {
        $message = new BankStatementMessage(
            $request->get('email'),
            $request->get('date_from'),
            $request->get('date_to')
        );

        $queue = Application::depency(BankStatementQueue::class);

        $queue->publish($message);

        $response->withBody($this->json([
            'result' => true,
            'message' => 'Выписка сформируется в ближайшее время и отправится вам на почту',
        ]));
    }
}