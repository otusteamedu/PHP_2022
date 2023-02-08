<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Controller;

use Nikcrazy37\Hw12\Connection\PdoConnection;
use Nikcrazy37\Hw12\Dto\DtoConnection;
use Nikcrazy37\Hw12\Map\Ticket\TicketMapper;
use Nikcrazy37\Hw12\Request\Request;

class TicketController
{
    private TicketMapper $ticketMapper;
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();

        $this->ticketMapper = new TicketMapper(
            PdoConnection::connection(
                new DtoConnection(
                    getenv("POSTGRES_HOST"),
                    getenv("POSTGRES_DB"),
                    getenv("POSTGRES_USER"),
                    getenv("POSTGRES_PASSWORD")
                )
            )
        );
    }

    public function index(): void
    {
        require_once ROOT . "/src/view/ticket/index.php";
    }

    public function create(): void
    {
        $row = array(
            "price" => (int)$this->request->price,
            "seat" => (int)$this->request->seat,
            "session_id" => (int)$this->request->sessionId,
        );

        $ticket = $this->ticketMapper->insert($row);

        $result["id"] = $ticket->getId();

        require_once ROOT . "/src/view/ticket/create.php";
    }

    public function read(): void
    {
        if ($this->request->exist("getAll")) {
            $ticketCollection = $this->ticketMapper->getAll();

            $result = $ticketCollection->getArray();

            require_once ROOT . "/src/view/ticket/readAll.php";
        } else {
            $ticket = $this->ticketMapper->findById((int)$this->request->id);

            $result = $ticket->getAll();

            require_once ROOT . "/src/view/ticket/read.php";
        }
    }

    public function update(): void
    {
        $ticket = $this->ticketMapper->findById((int)$this->request->id);

        $request = $this->request->getRequest();

        array_walk($request, function ($param, $key) use (&$ticket) {
            if ($key === "id") return;

            $method = "set" . ucfirst($key);
            $ticket->$method((int)$param);
        });

        $result = $this->ticketMapper->update($ticket);

        require_once ROOT . "/src/view/ticket/update.php";
    }

    public function delete(): void
    {
        $ticket = $this->ticketMapper->findById((int)$this->request->id);
        $result = $this->ticketMapper->delete($ticket);

        require_once ROOT . "/src/view/ticket/delete.php";
    }
}