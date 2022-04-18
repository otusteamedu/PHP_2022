<?php


namespace Decole\Hw13\Core\Services;


use Decole\Hw13\Core\Dtos\EventAddDto;
use Decole\Hw13\Core\Kernel;

class AddEventService
{
    /**
     * @param EventAddDto[] $dtos
     * @return void
     */
    public function addEvents(array $dtos): void
    {
        $service = new StorageService();

        foreach ($dtos as $dto) {
            $service->save($dto);
        }
    }

    public function createDtos(array $events): array
    {
        $result = [];

        foreach ($events as $event) {
            $dto = new EventAddDto();
            $dto->priority = (int)$event['priority'];
            $dto->condition = $event['conditions'];
            $dto->eventType = $event['event']['type'];

            $result[] = $dto;
        }

        return $result;
    }


}