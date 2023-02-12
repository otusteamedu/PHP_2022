<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Core;

use Nikcrazy37\Hw12\Core\Request\Request;
use Nikcrazy37\Hw12\Model\TicketMapper;
use Nikcrazy37\Hw12\Core\Connection\PdoConnecttion;
use Nikcrazy37\Hw12\Core\Dto\Connection;

class Controller
{
    public View $view;
    public Request $request;
    public TicketMapper $ticketMapper;

    public function __construct()
    {
        $this->request = new Request();
        
        $this->view = new View();
        
        $this->ticketMapper = new TicketMapper(
            PdoConnecttion::connection(
                new Connection(
                    getenv("POSTGRES_HOST"),
                    getenv("POSTGRES_DB"),
                    getenv("POSTGRES_USER"),
                    getenv("POSTGRES_PASSWORD")
                )
            )
        );
    }
}