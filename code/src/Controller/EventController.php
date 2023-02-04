<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Controller;

use Nikcrazy37\Hw11\Exception\EmptyRequestException;
use Nikcrazy37\Hw11\Model\EventModel;
use Nikcrazy37\Hw11\Repository\Repository;
use Nikcrazy37\Hw11\Request\Request;

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
     * @var Request
     */
    private Request $request;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->event = new EventModel();
        $this->request = new Request();
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
        $param = $this->event->prepareParam($this->request->param);
        $res = $this->repository->create($param, $this->request->score);

        require_once ROOT . "/src/view/event/create.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function read(): void
    {
        $res = $this->repository->read($this->request->id);

        require_once ROOT . "/src/view/event/read.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function update(): void
    {
        $param = $this->event->prepareParam($this->request->param);
        $res = $this->repository->update($param, $this->request->score, $this->request->id);

        require_once ROOT . "/src/view/event/update.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function delete(): void
    {
        if (isset($this->request->clear)) {
            $res = $this->repository->clear();
        } else {
            $res = $this->repository->delete($this->request->id);
        }

        require_once ROOT . "/src/view/event/delete.php";
    }

    /**
     * @return void
     * @throws EmptyRequestException
     */
    public function search(): void
    {
        $param = $this->event->prepareParam($this->request->param);
        $res = $this->repository->search($param);

        require_once ROOT . "/src/view/event/search.php";
    }
}