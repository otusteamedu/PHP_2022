<?php

namespace Study\Cinema\Infrastructure\Controller;

use Study\Cinema\Infrastructure\Service\Queue\StatementPublisher\StatementPublisher;
use Study\Cinema\Infrastructure\Service\Statement\StatementService;
use Study\Cinema\Infrastructure\View\View;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;

class StatementController
{
    private StatementService $statementService;

    public function __construct()
    {

    }

    public  function index()
    {

        View::render('statementForm', [
            'title' => 'Главная страница',
        ]);
    }
    public function get()
    {

        $cn = new RabbitMQConnector();
        $publisher = new  StatementPublisher($cn);

        $publisher->send($_REQUEST);

        View::render('statementRequestSend', [
            'title' => 'Подтверждение отправки запроса.',
        ]);
    }
    private function validate() {

    }


}