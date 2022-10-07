<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Component\DataMapper\IdentityMap;
use App\Application\Component\Event\EventDispatcher;
use App\Application\Component\Http\{Request, Response};
use App\Application\Controller\Traits\CreditRequestTree;
use App\Domain\Event\CreditRequested;
use Memcached;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CreditController extends AbstractController
{
    use CreditRequestTree;

    public function requestFormPage(
        Request $request,
        EventDispatcher $dispatcher,
        IdentityMap $identityMap,
        AMQPStreamConnection $amqpConnection,
        Memcached $memcached
    ): Response {

        if ($request->get('submit') !== null) {

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

            return $this->render('templates/credit_success.html');
        }

        return $this->render('templates/credit_form.html');
    }
}