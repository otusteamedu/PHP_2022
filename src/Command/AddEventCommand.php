<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

use Dkozlov\Otus\Exception\CommandParamsException;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Repository\Dto\AddEventRequest;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;

class AddEventCommand extends AbstractCommand
{
    private readonly string $name;

    private readonly int $priority;

    /**
     * @throws CommandParamsException
     */
    public function __construct(
        private readonly EventRepositoryInterface $repository,
        array $args
    ) {
        $name = $args[2] ?? '';

        if (!$name) {
            throw new CommandParamsException("Command required parameter \"name\" not entered");
        }

        $priority = $args[3] ?? '';

        if (!$priority) {
            throw new CommandParamsException("Command required parameter \"priority\" not entered");
        }

        $this->name = $name;
        $this->priority = (int) $priority;

        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $request = new AddEventRequest($this->name, $this->args, $this->priority);
            $this->repository->addEvent($request);

            $result = "Event \"{$this->name}\" was added";
        } catch (ConnectionTimeoutException $e) {
            $result = $e->getMessage();
        }

        echo $result . PHP_EOL;
    }
}