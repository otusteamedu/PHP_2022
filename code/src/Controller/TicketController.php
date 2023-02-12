<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Controller;

use Nikcrazy37\Hw12\Core\Controller;

class TicketController extends Controller
{
    public function index(): void
    {
        $this->view->generate("ticket/index.php");
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

        $this->view->generate("ticket/create.php", $result);
    }

    public function read(): void
    {
        if ($this->request->exist("getAll")) {
            $ticketCollection = $this->ticketMapper->getAll();

            $result = $ticketCollection->getArray();

            $this->view->generate("ticket/readAll.php", $result);
        } else {
            $ticket = $this->ticketMapper->findById((int)$this->request->id);

            $result = $ticket->getAll();

            $this->view->generate("ticket/read.php", $result);
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

        $this->view->generate("ticket/update.php", $result);
    }

    public function delete(): void
    {
        $ticket = $this->ticketMapper->findById((int)$this->request->id);
        $result = $this->ticketMapper->delete($ticket);

        $this->view->generate("ticket/delete.php", $result);
    }
}