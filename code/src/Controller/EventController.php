<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Controller;

use Nikcrazy37\Hw11\Exception\EmptyRequestException;
use Nikcrazy37\Hw11\Model\EventModel;
use Nikcrazy37\Hw11\Repository\Repository;

class EventController
{
    /**
     * @var Repository
     */
    private Repository $repository;
    /**
     * @var EventModel
     */
    private EventModel $event;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->event = new EventModel();
    }

    /**
     * @return void
     */
    public function index(): void
    {
        require_once ROOT . "/src/view/event/index.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function create(): void
    {
        $request = $this->event->getRequest("create");

        $res = $this->repository->create($request["param"], $request["score"]);

        require_once ROOT . "/src/view/event/create.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function read(): void
    {
        $request = $this->event->getRequest("read");

        $res = $this->repository->read($request["id"]);

        require_once ROOT . "/src/view/event/read.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function update(): void
    {
        $request = $this->event->getRequest("update");

        $res = $this->repository->update($request["param"], $request["score"], $request["id"]);

        require_once ROOT . "/src/view/event/update.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function delete(): void
    {
        $request = $this->event->getRequest("delete");

        if (isset($request["clear"])) {
            $res = $this->repository->clear();
        } else {
            $res = $this->repository->delete($request["id"]);
        }

        require_once ROOT . "/src/view/event/delete.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function search(): void
    {
        $request = $this->event->getRequest("search");

        $res = $this->repository->search($request["param"]);

        require_once ROOT . "/src/view/event/search.php";
    }
}