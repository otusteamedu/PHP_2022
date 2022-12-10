<?php

declare(strict_types=1);

namespace App\Src\Controllers;

use function cli\line;
use App\Src\Event\Event;
use App\Src\Kernel\Kernel;
use App\Src\Repositories\RepositoryDTO;
use App\Src\Repositories\Contracts\Repository;
use App\Src\Controllers\Validators\ControllerRequestValidator;

final class CliController
{
    private Repository $repository;

    /**
     * CliController class constructor
     */
    public function __construct()
    {
        $kernel = new Kernel();
        $kernel->initializeCliApplication();

        $this->repository = $kernel->repository();
    }

    /**
     * @param RepositoryDTO $repository_dto
     * @return void
     */
    public function addEvent(RepositoryDTO $repository_dto): void
    {
        if (!$this->validate(request: (array)$repository_dto, validation_method: 'validateAddEventRequest')) {
            return;
        }

        $event = new Event(repository_dto: $repository_dto);

        $this->repository->insert(event: $event);
    }

    /**
     * @return void
     */
    public function deleteAllEvents(): void
    {
        $this->repository->deleteAll();
        fwrite(stream: STDOUT, data: json_encode(value: 'Storage cleared') . PHP_EOL);
    }

    /**
     * @param RepositoryDTO $repository_dto
     * @return void
     */
    public function deleteConcreteEvent(RepositoryDTO $repository_dto): void
    {
        if (!$this->validate(request: (array)$repository_dto, validation_method: 'validateDeleteConcreteEvent')) {
            return;
        }

        $event = new Event(repository_dto: $repository_dto);

        $this->repository->deleteConcreteEvent(event: $event);
    }

    /**
     * @param RepositoryDTO $repository_dto
     * @return void
     */
    public function getAllEvents(RepositoryDTO $repository_dto): void
    {
        if (!$this->validate(request: (array)$repository_dto, validation_method: 'validateGetAllEvents')) {
            return;
        }

        $event = new Event(repository_dto: $repository_dto);

        fwrite(stream: STDOUT, data: json_encode(value: $this->repository->getAllEvents(event: $event)) . PHP_EOL);
    }

    /**
     * @param RepositoryDTO $repository_dto
     * @return void
     */
    public function getConcreteEvent(RepositoryDTO $repository_dto): void
    {
        if (!$this->validate(request: (array)$repository_dto, validation_method: 'validateGetConcreteEvent')) {
            return;
        }

        $event = new Event(repository_dto: $repository_dto);

        fwrite(stream: STDOUT, data: json_encode(value: $this->repository->getConcreteEvent(event: $event)) . PHP_EOL);
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param array $request
     * @param string $validation_method
     * @return bool
     */
    private function validate(array $request, string $validation_method): bool
    {
        $validator = new ControllerRequestValidator(request: $request);

        $validation_message = $validator->$validation_method();

        if (!empty($validation_message)) {
            line(msg: 'Ошибка валидации: ' . $validation_message);

            return false;
        }

        return true;
    }
}
