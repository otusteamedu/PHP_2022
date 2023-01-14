<?php

declare(strict_types=1);

namespace App\Src\Controllers;

use App\Src\Event\Event;
use App\Src\Infrastructure\Http\Http;
use App\Src\Repositories\RepositoryDTO;
use App\Src\Kernel\Configuration\Configurator;
use App\Src\Repositories\Contracts\Repository;
use App\Src\Controllers\Validators\ControllerRequestValidator;

final class ApiController
{
    private Repository $repository;
    private Http $http;
    private ControllerRequestValidator $validator;
    private array $request;

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->http = new Http();
        $this->request = $this->http->getRequestBody();

        $configurator = Configurator::getInstance();
        $this->repository = $configurator->getRepository();

        $this->validator = new ControllerRequestValidator(request: $this->request);
    }

    /**
     * @return void
     */
    public function addEvent(): void
    {
        if (!$this->validate(validation_method: 'validateAddEventRequest')) {
            return;
        }

        $this->repository->insert(
            event: new Event(
                repository_dto: new RepositoryDTO(
                    key: $this->request['key'],
                    score: $this->request['score'],
                    conditions: $this->request['conditions'],
                    event_description: $this->request['event_description']
                )
            )
        );

        $this->http->outputJsonResponse(response: 'Event added', http_code: 200);
    }

    /**
     * @return void
     */
    public function deleteAllEvents(): void
    {
        if (!$this->validate(validation_method: 'validateDeleteAllEvents')) {
            return;
        }

        $this->repository->deleteAll();

        $this->http->outputJsonResponse(response: ['Storage cleared'], http_code: 200);
    }

    /**
     * @return void
     */
    public function deleteConcreteEvent(): void
    {
        if (!$this->validate(validation_method: 'validateDeleteConcreteEvent')) {
            return;
        }

        $this->repository->deleteConcreteEvent(
            event: new Event(
                repository_dto: new RepositoryDTO(
                    key: $this->request['key'],
                    conditions: $this->request['conditions'],
                    event_description: $this->request['event_description']
                )
            )
        );

        $this->http
            ->outputJsonResponse(response: 'Event ' . $this->request['event_description'] . ' deleted', http_code: 200);
    }

    /**
     * @return void
     */
    public function getAllEvents(): void
    {
        if (!$this->validate(validation_method: 'validateGetAllEvents')) {
            return;
        }

        $events = $this->repository->getAllEvents(
            event: new Event(
                repository_dto: new RepositoryDTO(key: $this->request['key'])
            )
        );

        $this->http->outputJsonResponse(response: $events, http_code: 200, http_code_message: 'All events received');
    }

    /**
     * @return void
     */
    public function getConcreteEvent(): void
    {
        if (!$this->validate(validation_method: 'validateGetConcreteEvent')) {
            return;
        }

        $event = $this->repository->getConcreteEvent(
            event: new Event(
                repository_dto: new RepositoryDTO(key: $this->request['key'], conditions: $this->request['conditions'])
            )
        );

        $this->http->outputJsonResponse(response: $event, http_code: 200);
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    private function validate(string $validation_method): bool
    {
        $validation_message = $this->validator->$validation_method();

        if (!empty($validation_message)) {
            $this->http->outputJsonResponse(response: $validation_message, http_code: 422);

            return false;
        }

        return true;
    }
}
