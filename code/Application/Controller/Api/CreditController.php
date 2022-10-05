<?php

declare(strict_types=1);

namespace App\Application\Controller\Api;

use App\Application\Component\DataMapper\IdentityMap;
use App\Application\Component\Event\EventDispatcher;
use App\Application\Component\Http\{Request, Response};
use App\Application\Controller\AbstractController;
use App\Application\Controller\Traits\CreditRequestTree;
use App\Domain\Event\CreditRequested;
use Memcached;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CreditController extends AbstractController
{
    use CreditRequestTree;

    public function addCreditRequest(
        Request $request,
        EventDispatcher $dispatcher,
        IdentityMap $identityMap,
        AMQPStreamConnection $amqpConnection,
        Memcached $memcached
    ): Response {

        $data = [
            'lastname' => $request->get('lastname'),
            'firstname' => $request->get('firstname'),
            'middlename' => $request->get('middlename'),
            'passport_number' => $request->get('pass_number'),
            'passport_who' => $request->get('pass_place_code'),
            'passport_when' => $request->get('pass_issue_date'),
            'email_callback' => $request->get('email_callback'),
        ];

        $validation_tree = $this->getCreditRequestTree(...$data);
        $validation_tree->process();

        $dispatcher->dispatch(new CreditRequested($data, $identityMap, $amqpConnection, $memcached));

        $requestID = hash('sha256', $data['passport_number']." ".$data['email_callback']);

        $response = (object)[
            'creditRequestID' => $requestID,
            'links' => [
                'status' => 'GET /api/requests/'.$requestID.'/status',
            ],
        ];

        return new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);
    }

    public function getCreditRequestStatus(string $requestID, Memcached $memcached): Response
    {
        $status = $memcached->get($requestID);
        $response_status = ($status === false) ? 400 : 200;

        $response = (object)[
            'creditRequestID' => $requestID,
            'status' => ($status !== false) ? $status : 'NOT FOUND',
            'links' => [
                'add-request' => 'POST /api/requests',
            ],
        ];

        return new Response(json_encode($response), $response_status, ['Content-Type' => 'application/json']);
    }
}